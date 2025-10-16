<x-filament-panels::page>
    @php
        $data = $this->getData();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- CTV Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng CTV</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($data['ctv_stats']['total']) }}</p>
                    <p class="text-sm text-green-600">{{ $data['ctv_stats']['active'] }} hoạt động</p>
                </div>
            </div>
        </div>

        <!-- Applications -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Đơn Chờ Duyệt</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($data['applications']['pending']) }}</p>
                    <p class="text-sm text-gray-500">{{ $data['applications']['approved'] }} đã duyệt</p>
                </div>
            </div>
        </div>

        <!-- Commissions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng Hoa Hồng</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($data['commissions']['total']) }}đ</p>
                    <p class="text-sm text-orange-600">{{ number_format($data['commissions']['pending']) }}đ chờ duyệt</p>
                </div>
            </div>
        </div>

        <!-- Performance -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tỷ Lệ Chuyển Đổi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $data['performance']['conversion_rate'] }}%</p>
                    <p class="text-sm text-gray-500">{{ number_format($data['links']['clicks']) }} clicks</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top CTVs -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">🏆 Top CTV Xuất Sắc</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($data['top_ctvs'] as $index => $ctv)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ $index + 1 }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $ctv->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $ctv->affiliate_code }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ number_format($ctv->commissions_sum_commission_amount ?? 0) }}đ</p>
                                <p class="text-xs text-gray-500">{{ number_format($ctv->affiliate_links_sum_clicks ?? 0) }} clicks</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">📈 Hoạt Động Gần Đây</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Hoa hồng mới:</h4>
                        @foreach($data['recent_commissions']->take(5) as $commission)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                <div>
                                    <p class="text-sm text-gray-900">{{ $commission->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $commission->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ number_format($commission->commission_amount) }}đ</p>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $commission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($commission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $commission->status === 'pending' ? 'Chờ duyệt' : 
                                           ($commission->status === 'approved' ? 'Đã duyệt' : 'Đã trả') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($data['recent_applications']->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Đơn đăng ký mới:</h4>
                            @foreach($data['recent_applications'] as $application)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $application->full_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($application->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $application->status === 'pending' ? 'Chờ duyệt' : 
                                           ($application->status === 'approved' ? 'Đã duyệt' : 'Đã từ chối') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">⚡ Thao Tác Nhanh</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ \App\Filament\Resources\CollaboratorApplications\CollaboratorApplicationResource::getUrl() }}" 
               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Duyệt Đơn CTV</p>
                    <p class="text-xs text-gray-500">{{ $data['applications']['pending'] }} đơn chờ</p>
                </div>
            </a>

            <a href="{{ \App\Filament\Resources\Commissions\CommissionResource::getUrl() }}" 
               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Quản Lý Hoa Hồng</p>
                    <p class="text-xs text-gray-500">{{ number_format($data['commissions']['pending']) }}đ chờ duyệt</p>
                </div>
            </a>

            <a href="{{ \App\Filament\Resources\AffiliateLinks\AffiliateLinkResource::getUrl() }}" 
               class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Link Affiliate</p>
                    <p class="text-xs text-gray-500">{{ number_format($data['links']['total']) }} links</p>
                </div>
            </a>

            <a href="{{ \App\Filament\Resources\Users\UserResource::getUrl() }}" 
               class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m0 0V9a3 3 0 00-6 0v2.25"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Quản Lý CTV</p>
                    <p class="text-xs text-gray-500">{{ $data['ctv_stats']['total'] }} CTV</p>
                </div>
            </a>
        </div>
    </div>
</x-filament-panels::page>