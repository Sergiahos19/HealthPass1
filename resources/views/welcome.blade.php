@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative w-full pt-16 pb-24 px-marge-page overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center opacity-30" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAVcqWOYN-jmPVzksFQNH8TcvLt_tX1zca0-gNJO5Xt8usHo1NZaXl7ypjCyfN4tRN73MzT27dD40RBpL1DVlbKkT80JG0mKHvV5RDdASH2ncfXr008dDjhF-mpjM_4_xB8-WD_KTyxab7iwMnJlnDhP-9RjjN590oiZLibTxdcUYVN6mYV1rFPEVCGyciOYHaXAqf_pGHl_QwJqSja-sfXq-fi9-LPoo3uU4WGvA0lOQivZi4fmT4f9w')"></div>
            <div class="absolute inset-0 bg-linear-to-b from-background/80 via-background/95 to-background"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container-highest border border-outline-variant mb-6">
                <span class="material-symbols-outlined text-primary text-[16px]">verified_user</span>
                <span class="text-xs text-on-surface-variant">Réseau Médical Certifié</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-on-background max-w-4xl mb-6">Trouvez votre établissement de santé en toute confiance.</h1>
            <p class="text-lg text-on-surface-variant max-w-2xl mb-12">Accédez instantanément à des milliers de cliniques, hôpitaux et laboratoires certifiés. Un écosystème sécurisé pour votre parcours de soins.</p>
        </div>
    </section>

    <!-- Établissements Certifiés -->
    <section class="w-full py-16 px-marge-page bg-surface-bright">
        <div class="max-w-7xl mx-auto flex flex-col gap-inter-bloc">
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-bold text-on-background mb-2">Établissements Recommandés</h2>
                    <p class="text-base text-on-surface-variant">Sélection d'infrastructures médicales répondant aux plus hauts standards.</p>
                </div>
                    </section>

    
@endsection