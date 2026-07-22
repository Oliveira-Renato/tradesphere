<script setup>
defineProps({
  user: String,
  status: String
})
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 max-w-md w-full text-center shadow-2xl">
      <h1 class="text-3xl font-bold text-sky-400 mb-2">TradeSphere</h1>
      <p class="text-slate-400 mb-6">Painel de Gerenciamento de Estoque Multi-Tenant</p>

      <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-800 mb-6">
        <p class="text-sm text-emerald-400 font-mono">Status: {{ status }}</p>
        <p class="text-sm text-slate-300 mt-1">Desenvolvedor: <span class="font-bold text-white">{{ user }}</span></p>
      </div>

      <p class="text-xs text-slate-500">Vue 3 + Inertia.js + Laravel 12 no Docker</p>
    </div>
  </div>
</template>