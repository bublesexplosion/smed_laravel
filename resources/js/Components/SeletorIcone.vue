<script setup>
// Lista de ícones mapeados para o select nativo
const iconesAgrupados = [
  {
    categoria: '1. NAVEGAÇÃO E INSTITUCIONAL',
    opcoes: [
      { classe: 'fas fa-home', label: '🏠 Início / Home' },
      { classe: 'fas fa-building', label: '🏢 Prefeitura / Prédio' },
      { classe: 'fas fa-info-circle', label: 'ℹ️ Informações' },
      { classe: 'fas fa-map-marker-alt', label: '📍 Localização' },
      { classe: 'fas fa-link', label: '🔗 Link Padrão' }
    ]
  },
  {
    categoria: '2. COMUNICAÇÃO E MÍDIA',
    opcoes: [
      { classe: 'fas fa-newspaper', label: '📰 Notícias / Imprensa' },
      { classe: 'fas fa-calendar-alt', label: '📅 Eventos / Agenda' },
      { classe: 'fas fa-bullhorn', label: '📢 Ouvidoria / Avisos' },
      { classe: 'fas fa-phone', label: '📞 Contatos / Telefones' },
      { classe: 'fas fa-envelope', label: '✉️ E-mail / Mensagens' },
      { classe: 'fas fa-comments', label: '💬 Chat / Atendimento Online' },
      { classe: 'fas fa-images', label: '🖼️ Banners / Fotos' },
      { classe: 'fas fa-camera', label: '📷 Galeria / Fotos' }
    ]
  },
  {
    categoria: '3. COMANDOS E AÇÕES DO SISTEMA (CRUD)',
    opcoes: [
      { classe: 'fa fa-plus-circle', label: '➕ Adicionar / Incluir' },
      { classe: 'fa fa-minus-circle', label: '➖ Remover / Excluir' },
      { classe: 'fas fa-edit', label: '📝 Editar / Alterar' },
      { classe: 'fas fa-save', label: '💾 Salvar / Gravar' },
      { classe: 'fas fa-trash', label: '🗑️ Excluir / Apagar' },
      { classe: 'fas fa-times-circle', label: '❌ Cancelar / Fechar' },
      { classe: 'fas fa-check', label: '✔️ Confirmar / Aprovar' },
      { classe: 'fas fa-eye', label: '👁️ Visualizar / Ver' },
      { classe: 'fas fa-sync-alt', label: '🔄 Atualizar / Sincronizar' },
      { classe: 'fas fa-arrow-left', label: '⬅️ Voltar / Retornar' },
      { classe: 'fas fa-share-square', label: '📤 Exportar / Compartilhar' },
      { classe: 'fas fa-search', label: '🔍 Consulta / Busca' },
      { classe: 'fas fa-download', label: '📥 Downloads / Arquivos' }
    ]
  },
  {
    categoria: '4. DOCUMENTOS, PASTA E ARQUIVOS',
    opcoes: [
      { classe: 'fas fa-file-alt', label: '📄 Documentos / Leis' },
      { classe: 'fas fa-folder', label: '📁 Pasta / Documentos' },
      { classe: 'fas fa-folder-open', label: '📂 Pasta Aberta' },
      { classe: 'fas fa-archive', label: '🗄️ Arquivo Morto / Protocolo' },
      { classe: 'fas fa-clipboard-list', label: '📋 Inscrições / Formulários' },
      { classe: 'fas fa-certificate', label: '📜 Certidões / Alvarás' },
      { classe: 'fas fa-scroll', label: '📜 Folder / Informativo' },
      { classe: 'fas fa-map', label: '🗺️ Folder / Guia Desdobrável' },
      { classe: 'fas fa-book-open', label: '📖 Folder / Livrete' }
    ]
  },
  {
    categoria: '5. GESTÃO INTERNA, RH E JURÍDICO',
    opcoes: [
      { classe: 'fas fa-users', label: '👥 Usuários / População' },
      { classe: 'fas fa-user-tie', label: '👤 Servidores / RH' },
      { classe: 'fas fa-gavel', label: '🔨 Licitações / Editais' },
      { classe: 'fas fa-balance-scale', label: '⚖️ Controladoria / Jurídico' },
      { classe: 'fas fa-signature', label: '✍️ Contratos / Convênios' },
      { classe: 'fas fa-chart-bar', label: '📊 Transparência' },
      { classe: 'fas fa-money-bill-wave', label: '💵 Finanças / Impostos' },
      { classe: 'fas fa-calculator', label: '🧮 Simulador / Cálculo' },
      { classe: 'fas fa-medal', label: '🏅 Premiações / Conquistas' }
    ]
  },
  {
    categoria: '6. TI, CONFIGURAÇÕES E SEGURANÇA',
    opcoes: [
      { classe: 'fas fa-cogs', label: '⚙️ Serviços / Painel' },
      { classe: 'fas fa-desktop', label: '🖥️ Sistemas / TI' },
      { classe: 'fas fa-wifi', label: '📶 Wi-Fi Público / Internet' },
      { classe: 'fas fa-key', label: '🔑 Acesso / Senhas' },
      { classe: 'fas fa-lock', label: '🔒 Segurança / Criptografia' },
      { classe: 'fas fa-user-shield', label: '🛡️ Permissões / Níveis de Acesso' },
      { classe: 'fas fa-id-card-alt', label: '🪪 Cadastro de Usuários / Perfis' },
      { classe: 'fas fa-sliders-h', label: '🎛️ Ajustes / Parâmetros Globais' },
      { classe: 'fas fa-history', label: '⏳ Logs / Histórico do Sistema' },
      { classe: 'fas fa-database', label: '🗄️ Banco de Dados / Backup' },
      { classe: 'fas fa-ban', label: '🚫 Bloquear / Inativar' },
      { classe: 'fas fa-exclamation-triangle', label: '⚠️ Alertas / Erros do Sistema' },
      { classe: 'fas fa-terminal', label: '💻 Desenvolvedor / Console API' }
    ]
  },
  {
    categoria: '7. SERVIÇOS PÚBLICOS E INFRAESTRUTURA',
    opcoes: [
      { classe: 'fas fa-tools', label: '🛠️ Obras / Manutenção' },
      { classe: 'fas fa-hard-hat', label: '👷 Engenharia / Fiscalização' },
      { classe: 'fas fa-lightbulb', label: '💡 Iluminação Pública' },
      { classe: 'fas fa-faucet', label: '🚰 Saneamento / Água' },
      { classe: 'fas fa-trash-alt', label: '🗑️ Coleta de Lixo' },
      { classe: 'fas fa-plug', label: '🔌 Energia / Infraestrutura' }
    ]
  },
  {
    categoria: '8. TRANSPORTE, TRÂNSITO E LOGÍSTICA',
    opcoes: [
      { classe: 'fas fa-bus', label: '🚌 Transporte / Trânsito' },
      { classe: 'fas fa-ship', label: '🚢 Porto / Hidroviário' },
      { classe: 'fas fa-plane', label: '✈️ Aeroporto / Turismo' }
    ]
  },
  {
    categoria: '9. SAÚDE, SEGURANÇA E EMERGÊNCIA',
    opcoes: [
      { classe: 'fas fa-heartbeat', label: '🏥 Saúde / Hospitais' },
      { classe: 'fas fa-ambulance', label: '🚑 Urgência / Resgate' },
      { classe: 'fas fa-shield-alt', label: '🛡️ Segurança / Guarda' },
      { classe: 'fas fa-fire', label: '🔥 Defesa Civil / Emergência' }
    ]
  },
  {
    categoria: '10. DESENVOLVIMENTO SOCIAL E CIDADANIA',
    opcoes: [
      { classe: 'fas fa-hand-holding-heart', label: '🤟 Assistência Social' },
      { classe: 'fas fa-hands-helping', label: '🤝 Parcerias / Voluntariado' },
      { classe: 'fas fa-wheelchair', label: '♿ Acessibilidade' },
      { classe: 'fas fa-dog', label: '🐶 Causa Animal / Zoonoses' },
      { classe: 'fas fa-question-circle', label: '❓ Ajuda / FAQ' }
    ]
  },
  {
    categoria: '11. EDUCAÇÃO, CULTURA E LAZER',
    opcoes: [
      { classe: 'fas fa-graduation-cap', label: '🎓 Educação / Escolas' },
      { classe: 'fas fa-utensils', label: '🍲 Alimentação / Merenda' },
      { classe: 'fas fa-theater-masks', label: '🎭 Cultura / Teatros' },
      { classe: 'fas fa-football-ball', label: '🏈 Esporte / Lazer' },
      { classe: 'fas fa-monument', label: '🗿 Patrimônio / Histórico' },
      { classe: 'fas fa-map', label: '🗺️ Mapas / Turismo' }
    ]
  },
  {
    categoria: '12. ECONOMIA E SETORES PRODUTIVOS',
    opcoes: [
      { classe: 'fas fa-briefcase', label: '💼 Empregos / Vagas' },
      { classe: 'fas fa-industry', label: '🏭 Indústria / Empresas' },
      { classe: 'fas fa-store', label: '🏪 Comércio / Feiras' },
      { classe: 'fas fa-tractor', label: '🚜 Agricultura / Rural' },
      { classe: 'fas fa-tree', label: '🌳 Meio Ambiente / Praças' }
    ]
  },
   {
    categoria: '13. Para Menu Administrativo',
    opcoes: [
      { classe: 'fas fa-solar-panel', label: '☀️ Solar' },
      { classe: 'fas fa-id-card', label: '🪪 Seguro Social' },
      { classe: 'fas fa-file-alt', label: '📜 Edital' },
      { classe: 'fas fa-leaf', label: '🌱 Biomassa' },
      { classe: 'fas fa-gavel', label: '📝 Pré-Projeto' },
      { classe: 'fas fa-box', label: '📦 Material' }
    ]
  }
];

defineProps({
  modelValue: {
    type: String,
    default: 'fas fa-link'
  }
});

defineEmits(['update:modelValue']);
</script>

<template>
  <div class="form-group">
    <label>Ícone (FontAwesome)</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">
          <!-- Mantém a pré-visualização do ícone dinâmico do AdminLTE -->
          <i :class="modelValue || 'fas fa-link'"></i>
        </span>
      </div>
      
      <!-- Select nativo do Bootstrap: abre perfeitamente por cima de qualquer modal -->
      <select 
        :value="modelValue" 
        @change="$emit('update:modelValue', $event.target.value)" 
        class="form-control text-dark"
      >
       <!-- Percorre cada grupo de categorias -->
        <optgroup 
          v-for="grupo in iconesAgrupados" 
          :key="grupo.categoria" 
          :label="grupo.categoria"
        >
          <!-- Percorre os ícones daquela categoria específica -->
          <option 
            v-for="icon in grupo.opcoes" 
            :key="icon.classe" 
            :value="icon.classe"
          >
            {{ icon.label }}
          </option>
        </optgroup>
      </select>
    </div>
  </div>
</template>
