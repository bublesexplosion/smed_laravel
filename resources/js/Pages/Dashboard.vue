<template>
    <AdminLayout>
        <!-- Injeta o Cabeçalho Oficial no Slot de Header do Layout -->
        <template #header>
            <GovBrHeader titulo="Projeto LVGA" />
        </template>

        <!-- Conteúdo Principal do Dashboard -->
        <div class="pt-4 px-3">
            <div class="container-fluid">
                <div class="row">
                    
                    <!-- Card 1: Usuários -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="br-card hover shadow-sm bg-white p-4 border rounded">
                            <div class="card-content d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">Usuários</p>
                                    <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 2rem;">{{ totalUsuarios }}</h2>
                                </div>
                                <div class="text-primary bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Grupos -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="br-card hover shadow-sm bg-white p-4 border rounded">
                            <div class="card-content d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">Grupos</p>
                                    <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 2rem;">{{ totalGrupos }}</h2>
                                </div>
                                <div class="text-success bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Seções -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="br-card hover shadow-sm bg-white p-4 border rounded">
                            <div class="card-content d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">Seções</p>
                                    <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 2rem;">{{ totalSecoes }}</h2>
                                </div>
                                <div class="text-warning bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-th-list fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Itens -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="br-card hover shadow-sm bg-white p-4 border rounded">
                            <div class="card-content d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">Itens</p>
                                    <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 2rem;">{{ totalItens }}</h2>
                                </div>
                                <div class="text-info bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-sitemap fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import GovBrHeader from '@/Components/GovBrHeader.vue';

    // Mapeamento das propriedades passadas pelo Laravel Controller
    defineProps({
        totalUsuarios: { type: Number, default: 0 },
        totalGrupos: { type: Number, default: 0 },
        totalSecoes: { type: Number, default: 0 },
        totalItens: { type: Number, default: 0 },
       
       
    });
</script>

<style scoped>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: drop-shadow(0px 0px 3px rgba(0,0,0,0.5));
    }
</style>
