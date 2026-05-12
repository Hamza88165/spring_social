<x-layouts.app title="Tableau de bord">

    {{-- ── STATS ROW ── --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Clients</div>
                        <div class="stat-value">{{ $totalClients }}</div>
                        <span class="stat-badge" style="background:#EBF1F8;color:#185FA5;">
                            <i class="bi bi-people"></i> Total
                        </span>
                    </div>
                    <div class="stat-icon-wrap" style="background:#EBF1F8;">
                        <i class="bi bi-people-fill" style="color:#2E75B6;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Comptes connectés</div>
                        <div class="stat-value">{{ $totalAccounts }}</div>
                        <span class="stat-badge" style="background:#EAF3DE;color:#3B6D11;">
                            <i class="bi bi-check-circle"></i> Actifs
                        </span>
                    </div>
                    <div class="stat-icon-wrap" style="background:#EAF3DE;">
                        <i class="bi bi-link-45deg" style="color:#3B6D11;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Posts aujourd'hui</div>
                        <div class="stat-value">{{ $scheduledToday }}</div>
                        <span class="stat-badge" style="background:#FAEEDA;color:#854F0B;">
                            <i class="bi bi-clock"></i> Planifiés
                        </span>
                    </div>
                    <div class="stat-icon-wrap" style="background:#FAEEDA;">
                        <i class="bi bi-calendar-check" style="color:#BA7517;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Messages non lus</div>
                        <div class="stat-value">{{ $unreadMessages }}</div>
                        <span class="stat-badge" style="background:#FCEBEB;color:#A32D2D;">
                            <i class="bi bi-chat-dots"></i> Inbox
                        </span>
                    </div>
                    <div class="stat-icon-wrap" style="background:#FCEBEB;">
                        <i class="bi bi-chat-dots-fill" style="color:#E24B4A;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── BOTTOM ROW ── --}}
    <div class="row g-3">

        {{-- Recent Clients --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-people me-2" style="color:#2E75B6;"></i>Clients récents</span>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">
                        Voir tous
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Secteur</th>
                                <th>Comptes</th>
                                <th>Ajouté le</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentClients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:32px;height:32px;border-radius:8px;
                                                    background:#EBF1F8;color:#2E75B6;
                                                    display:flex;align-items:center;
                                                    justify-content:center;font-weight:700;
                                                    font-size:11px;">
                                            {{ strtoupper(substr($client->name, 0, 2)) }}
                                        </div>
                                        <span style="font-weight:500;font-size:13px;">
                                            {{ $client->name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($client->industry)
                                        <span class="tag" style="background:#EBF1F8;color:#185FA5;">
                                            {{ $client->industry }}
                                        </span>
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-size:13px;color:#666;">
                                        {{ $client->socialAccounts->count() }}
                                        compte{{ $client->socialAccounts->count() > 1 ? 's' : '' }}
                                    </span>
                                </td>
                                <td style="color:#999;font-size:12px;">
                                    {{ $client->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('clients.show', $client) }}"
                                       class="btn btn-sm"
                                       style="background:#F4F6FB;color:#2E75B6;
                                              border:1px solid #EAECF0;border-radius:7px;
                                              font-size:12px;padding:4px 12px;">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5" style="color:#bbb;">
                                    <i class="bi bi-people" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                                    Aucun client pour le moment
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Quick Info Panel --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-lightning me-2" style="color:#BA7517;"></i>Aperçu rapide
                </div>
                <div class="card-body p-3">

                    {{-- Platforms breakdown --}}
                    <div style="font-size:11px;font-weight:600;color:#999;
                                text-transform:uppercase;letter-spacing:0.06em;
                                margin-bottom:12px;">
                        Plateformes connectées
                    </div>

                    @php
                        $fbCount = \App\Models\SocialAccount::where('platform','facebook')->count();
                        $igCount = \App\Models\SocialAccount::where('platform','instagram')->count();
                    @endphp

                    <div class="d-flex align-items-center gap-3 mb-3 p-2"
                         style="background:#F4F6FB;border-radius:10px;">
                        <div style="width:34px;height:34px;border-radius:8px;
                                    background:#E6F1FB;display:flex;align-items:center;
                                    justify-content:center;color:#185FA5;font-weight:700;
                                    font-size:13px;">f</div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:500;color:#1B2B4B;">Facebook</div>
                            <div style="font-size:11px;color:#999;">{{ $fbCount }} page{{ $fbCount > 1 ? 's' : '' }} connectée{{ $fbCount > 1 ? 's' : '' }}</div>
                        </div>
                        <span class="tag" style="background:#EBF1F8;color:#185FA5;">{{ $fbCount }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4 p-2"
                         style="background:#F4F6FB;border-radius:10px;">
                        <div style="width:34px;height:34px;border-radius:8px;
                                    background:#FBEAF0;display:flex;align-items:center;
                                    justify-content:center;color:#993556;font-weight:700;
                                    font-size:11px;">IG</div>
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:500;color:#1B2B4B;">Instagram</div>
                            <div style="font-size:11px;color:#999;">{{ $igCount }} compte{{ $igCount > 1 ? 's' : '' }} connecté{{ $igCount > 1 ? 's' : '' }}</div>
                        </div>
                        <span class="tag" style="background:#FBEAF0;color:#993556;">{{ $igCount }}</span>
                    </div>

                    <hr style="border-color:#EAECF0;margin:12px 0;">

                    {{-- Quick actions --}}
                    <div style="font-size:11px;font-weight:600;color:#999;
                                text-transform:uppercase;letter-spacing:0.06em;
                                margin-bottom:10px;">
                        Actions rapides
                    </div>

                    <a href="{{ route('clients.create') }}"
                       class="d-flex align-items-center gap-2 p-2 mb-2"
                       style="background:#EBF1F8;border-radius:9px;text-decoration:none;
                              color:#185FA5;font-size:13px;font-weight:500;">
                        <i class="bi bi-person-plus"></i> Nouveau client
                    </a>

                    <a href="#"
                       class="d-flex align-items-center gap-2 p-2"
                       style="background:#EAF3DE;border-radius:9px;text-decoration:none;
                              color:#3B6D11;font-size:13px;font-weight:500;">
                        <i class="bi bi-plus-square"></i> Nouveau post
                    </a>

                </div>
            </div>
        </div>

    </div>

</x-layouts.app>