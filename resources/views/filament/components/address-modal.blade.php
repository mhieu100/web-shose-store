<div class="space-y-4">
    @if($shipping)
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Địa chỉ giao hàng
            </h3>
            
            <div class="space-y-2 text-sm">
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Địa chỉ:</span>
                    <span class="text-gray-900">{{ $shipping['address_line_1'] ?? 'Chưa có thông tin' }}</span>
                </div>
                
                @if(!empty($shipping['address_line_2']))
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Địa chỉ 2:</span>
                    <span class="text-gray-900">{{ $shipping['address_line_2'] }}</span>
                </div>
                @endif
                
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Thành phố:</span>
                    <span class="text-gray-900">{{ $shipping['city'] ?? 'Chưa có thông tin' }}</span>
                </div>
                
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Tỉnh/Thành:</span>
                    <span class="text-gray-900">{{ $shipping['state'] ?? 'Chưa có thông tin' }}</span>
                </div>
                
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Mã bưu chính:</span>
                    <span class="text-gray-900">{{ $shipping['postal_code'] ?? 'Chưa có thông tin' }}</span>
                </div>
                
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Quốc gia:</span>
                    <span class="text-gray-900">{{ $shipping['country'] ?? 'Chưa có thông tin' }}</span>
                </div>
                
                @if(!empty($shipping['phone']))
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Điện thoại:</span>
                    <span class="text-gray-900">{{ $shipping['phone'] }}</span>
                </div>
                @endif
                
                @if(!empty($shipping['notes']))
                <div class="flex">
                    <span class="font-medium text-gray-600 w-32">Ghi chú:</span>
                    <span class="text-gray-900">{{ $shipping['notes'] }}</span>
                </div>
                @endif
            </div>
            
            <div class="mt-4 pt-3 border-t border-gray-200">
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Địa chỉ được xác nhận từ đơn hàng
                </div>
            </div>
        </div>
        
        <!-- Copy Address Button -->
        <div class="flex justify-end">
            <button 
                type="button" 
                onclick="copyAddressToClipboard()" 
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                </svg>
                Sao chép địa chỉ
            </button>
        </div>
        
        <script>
            function copyAddressToClipboard() {
                const address = `{{ $shipping['address_line_1'] ?? '' }}{{ !empty($shipping['address_line_2']) ? ', ' . $shipping['address_line_2'] : '' }}, {{ $shipping['city'] ?? '' }}, {{ $shipping['state'] ?? '' }} {{ $shipping['postal_code'] ?? '' }}, {{ $shipping['country'] ?? '' }}{{ !empty($shipping['phone']) ? ' - Phone: ' . $shipping['phone'] : '' }}`;
                
                navigator.clipboard.writeText(address).then(function() {
                    // Show success notification (if using Filament notifications)
                    window.$wireui?.notify({
                        title: 'Đã sao chép!',
                        description: 'Địa chỉ đã được sao chép vào clipboard',
                        icon: 'success'
                    });
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                });
            }
        </script>
    @else
        <div class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Không có thông tin địa chỉ</h3>
            <p class="text-gray-500">Đơn hàng này chưa có thông tin địa chỉ giao hàng.</p>
        </div>
    @endif
</div>