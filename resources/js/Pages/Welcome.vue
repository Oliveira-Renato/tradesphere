<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    user: String,
    products: Array
});

const loadingId = ref(null);
const feedbackMessage = ref(null);

// Função reativa para dar baixa no estoque via API
const reduceStock = async (productId) => {
    loadingId.value = productId;
    feedbackMessage.value = null;

    try {
        const response = await fetch('/api/stock/reduce', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        });

        const data = await response.json();

        if (data.success) {
            feedbackMessage.value = { type: 'success', text: data.message };
            // Atualiza os dados da página via Inertia sem recarregar a tela
            router.reload({ only: ['products'] });
        } else {
            feedbackMessage.value = { type: 'error', text: data.message };
        }
    } catch (error) {
        feedbackMessage.value = { type: 'error', text: 'Erro ao conectar com o servidor.' };
    } finally {
        loadingId.value = null;
    }
};
</script>

<template>
  <div class="min-h-screen bg-slate-900 text-slate-100 p-8 font-sans">
    <div class="max-w-5xl mx-auto">
      
      <!-- Cabeçalho -->
      <header class="flex justify-between items-center mb-8 border-b border-slate-800 pb-6">
        <div>
          <h1 class="text-3xl font-bold text-sky-400">TradeSphere</h1>
          <p class="text-slate-400 text-sm mt-1">Gestão de Estoque Multi-Tenant com Concorrência Atômica</p>
        </div>
        <div class="text-right">
          <span class="inline-block bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full text-xs font-mono">
            Online • PostgreSQL
          </span>
          <p class="text-xs text-slate-400 mt-1">Dev: <strong class="text-white">{{ user }}</strong></p>
        </div>
      </header>

      <!-- Mensagens de Feedback -->
      <div v-if="feedbackMessage" :class="[
        'p-4 rounded-lg mb-6 border text-sm font-medium transition-all',
        feedbackMessage.type === 'success' 
          ? 'bg-emerald-950/50 border-emerald-500/30 text-emerald-300' 
          : 'bg-rose-950/50 border-rose-500/30 text-rose-300'
      ]">
        {{ feedbackMessage.text }}
      </div>

      <!-- Tabela de Produtos -->
      <div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-900/60 border-b border-slate-700 text-xs font-semibold text-slate-400 uppercase tracking-wider">
              <th class="p-4">Empresa (Tenant)</th>
              <th class="p-4">SKU / Produto</th>
              <th class="p-4">Preço Un.</th>
              <th class="p-4">Qtd. Estoque</th>
              <th class="p-4 text-right">Ação</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-700/50 text-sm">
            <tr v-for="product in products" :key="product.id" class="hover:bg-slate-700/30 transition-colors">
              <td class="p-4">
                <span class="font-medium text-slate-200">{{ product.tenant?.name }}</span>
              </td>
              <td class="p-4">
                <div class="font-semibold text-white">{{ product.name }}</div>
                <div class="text-xs text-slate-400 font-mono">{{ product.sku }}</div>
              </td>
              <td class="p-4 text-slate-300">
                R$ {{ parseFloat(product.price).toFixed(2) }}
              </td>
              <td class="p-4">
                <span :class="[
                  'px-2.5 py-1 rounded-md text-xs font-mono font-bold',
                  product.inventory?.quantity > 0 ? 'bg-sky-500/10 text-sky-400 border border-sky-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'
                ]">
                  {{ product.inventory?.quantity ?? 0 }} un.
                </span>
              </td>
              <td class="p-4 text-right">
                <button 
                  @click="reduceStock(product.id)"
                  :disabled="loadingId === product.id || product.inventory?.quantity <= 0"
                  class="bg-sky-600 hover:bg-sky-500 disabled:bg-slate-700 disabled:text-slate-500 text-white font-medium px-4 py-2 rounded-lg text-xs transition-all shadow-md active:scale-95">
                  {{ loadingId === product.id ? 'Processando...' : 'Vender (-1)' }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</template>