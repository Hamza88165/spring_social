<x-layouts.app title="Tableau de bord">

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:0.8rem;color:#888;text-transform:uppercase;
                                 letter-spacing:0.04em;">Clients</span>
                    <div class="stat-icon" style="background:#EBF1F8;">
                        <i class="bi bi-people" style="color:#2E75B6"></i>
                    </div>
                </div>
                <div style="font-size:1.8rem;font-weight:700;color:#1B2B4B;">
                    {{ $totalClients }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:0.8rem;color:#888;text-transform:uppercase;
                                 letter-spacing:0.04em;">Comptes connectés</span>
                    <div class="stat-icon" style="background:#EEF6EE;">
                        <i class="bi bi-link-45deg" style="color:#2E7D32"></i>
                    </div>
                </div>
                <div style="font-size:1.8rem;font-weight:700;color:#1B2B4B;">
                    {{ $totalAccounts }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:0.8rem;color:#888;text-transform:uppercase;
                                 letter-spacing:0.04em;">Posts aujourd'hui</span>
                    <div class="stat-icon" style="background:#FFF8E1;">
                        <i class="bi bi-calendar-check" style="color:#F9A825"></i>
                    </div>
                </div>
                <div style="font-size:1.8rem;font-weight:700;color:#1B2B4B;">
                    {{ $scheduledToday }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="font-size:0.8rem;color:#888;text-transform:uppercase;
                                 letter-spacing:0.04em;">Messages non lus</span>
                    <div class="stat-icon" style="background:#FEF0F0;">
                        <i class="bi bi-chat-dots" style="color:#E53935"></i>
                    </div>
                </div>
                <div style="font-size:1.8rem;font-weight:700;color:#1B2B4B;">
                    {{ $unreadMessages }}
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Clients --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
            <span><i class="bi bi-people me-2"></i>Clients récents</span>
            <a href="{{ route('clients.index') }}" class="btn btn-aymd btn-sm">
                Voir tous
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Secteur</th>
                        <th class="px-4 py-3">Ajouté le</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentClients as $client)
                    <tr>
                        <td class="px-4 py-3 fw-500">{{ $client->name }}</td>
                        <td class="px-4 py-3">
                            <span class="badge"
                                  style="background:#EBF1F8;color:#2E75B6;
                                         font-weight:500;font-size:0.78rem;">
                                {{ $client->industry ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3" style="color:#888;">
                            {{ $client->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('clients.show', $client) }}"
                               class="btn btn-sm"
                               style="background:#EBF1F8;color:#2E75B6;
                                      border-radius:6px;font-size:0.8rem;">
                                Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4" style="color:#888;">
                            Aucun client pour le moment
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>