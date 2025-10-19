@props(['product'])

@auth
    @if(Auth::user()->isActiveAffiliate())
        <div class="affiliate-share-section mt-3">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="shareProduct({{ $product->id }})">
                <i class="fa fa-share-alt"></i> Share & Kiếm Hoa Hồng
            </button>
            
            <!-- Hidden input to store affiliate link -->
            <input type="hidden" id="affiliate-link-{{ $product->id }}" value="">
        </div>

        <script>
        function shareProduct(productId) {
            // Get or create affiliate link
            fetch(`/affiliate/get-link/${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Store link for later use
                    document.getElementById(`affiliate-link-${productId}`).value = data.link;
                    
                    // Show share modal
                    showShareModal(data.link, productId);
                } else {
                    alert('Lỗi: ' + (data.error || 'Không thể tạo link affiliate'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tạo link affiliate');
            });
        }

        function showShareModal(link, productId) {
            // Create modal dynamically
            const modalHtml = `
                <div class="modal fade" id="shareModal${productId}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Share Sản Phẩm & Kiếm Hoa Hồng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Link affiliate của bạn:</strong></p>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="shareLink${productId}" value="${link}" readonly>
                                    <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('shareLink${productId}')">
                                        Copy
                                    </button>
                                </div>
                                
                                <p class="text-muted small">
                                    💡 <strong>Hướng dẫn:</strong><br>
                                    • Copy link trên và chia sẻ cho bạn bè, khách hàng<br>
                                    • Khi có người mua qua link của bạn, bạn sẽ nhận hoa hồng {{ Auth::user()->commission_rate }}%<br>
                                    • Hoa hồng sẽ được tính vào tài khoản CTV của bạn
                                </p>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" onclick="shareToSocial('${link}', 'facebook')">
                                        <i class="fab fa-facebook"></i> Share Facebook
                                    </button>
                                    <button class="btn btn-info" onclick="shareToSocial('${link}', 'zalo')">
                                        <i class="fab fa-zalo"></i> Share Zalo
                                    </button>
                                    <button class="btn btn-primary" onclick="shareToSocial('${link}', 'messenger')">
                                        <i class="fab fa-facebook-messenger"></i> Share Messenger
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById(`shareModal${productId}`);
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById(`shareModal${productId}`));
            modal.show();
        }

        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value).then(() => {
                alert('Đã copy link thành công!');
            });
        }

        function shareToSocial(link, platform) {
            const productName = '{{ $product->name }}';
            const text = `Mình đang giới thiệu sản phẩm "${productName}" chất lượng này. Bạn xem qua nhé!`;
            
            let shareUrl = '';
            
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}&quote=${encodeURIComponent(text)}`;
                    break;
                case 'zalo':
                    shareUrl = `https://zalo.me/share?url=${encodeURIComponent(link)}&title=${encodeURIComponent(text)}`;
                    break;
                case 'messenger':
                    shareUrl = `https://www.facebook.com/dialog/send?link=${encodeURIComponent(link)}&app_id=YOUR_APP_ID&redirect_uri=${encodeURIComponent(window.location.href)}`;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }
        </script>
    @endif
@endauth