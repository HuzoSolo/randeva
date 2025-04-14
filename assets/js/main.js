/**
 * Randeva Main JavaScript Functions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const body = document.body;
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    
    // Kullanıcının sidebar tercihini localStorage'da saklama
    function saveSidebarState(isOpen) {
        localStorage.setItem('sidebarState', isOpen ? 'open' : 'closed');
    }
    
    // Kaydedilmiş sidebar tercihini getirme
    function getSavedSidebarState() {
        return localStorage.getItem('sidebarState') || 'open'; // Varsayılan olarak açık
    }
    
    // Sidebar durumunu arayüze uygulama
    function applySidebarState(state) {
        if (state === 'closed') {
            body.classList.add('sidebar-closed');
        } else {
            body.classList.remove('sidebar-closed');
        }
    }
    
    // Sayfa yüklendiğinde, kaydedilmiş tercih veya ekran boyutuna göre sidebar durumunu ayarla
    const isMobile = window.matchMedia('(max-width: 992px)').matches;
    
    if (isMobile) {
        // Mobil cihazlarda sidebar her zaman kapalı başlar ve açıldığında sidebar-open class'ı eklenir
        body.classList.remove('sidebar-closed');
    } else {
        // Desktop'ta kaydedilmiş tercihe göre sidebar durumunu ayarla
        const savedState = getSavedSidebarState();
        applySidebarState(savedState);
    }
    
    // Sidebar toggle butonu işlevselliği
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (isMobile) {
                // Mobil cihazlarda sidebar-open class'ını toggle et
                body.classList.toggle('sidebar-open');
            } else {
                // Desktop'ta sidebar-closed class'ını toggle et
                body.classList.toggle('sidebar-closed');
                // Kullanıcı tercihini kaydet
                saveSidebarState(!body.classList.contains('sidebar-closed'));
            }
        });
    }
    
    // Backdrop'a tıklama ile sidebar'ı kapatma (sadece mobil)
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', function() {
            body.classList.remove('sidebar-open');
        });
    }
    
    // Mobil cihazlarda nav item'a tıklayınca sidebar'ı kapat
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    if (isMobile) {
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                body.classList.remove('sidebar-open');
            });
        });
    }
    
    // Ekran boyutu değiştiğinde responsive davranış
    window.addEventListener('resize', function() {
        const newIsMobile = window.matchMedia('(max-width: 992px)').matches;
        
        if (newIsMobile) {
            // Responsive breakpoint'ten küçük ekranlara geçiş yapılınca
            body.classList.remove('sidebar-closed'); // sidebar-closed'ı kaldır
            if (body.classList.contains('sidebar-open')) {
                body.classList.remove('sidebar-open'); // Açık sidebar'ı kapat
            }
        } else {
            // Büyük ekranlara geçiş yapılınca
            body.classList.remove('sidebar-open'); // sidebar-open'ı kaldır
            
            // Kullanıcının kaydedilmiş tercihini uygula
            const savedState = getSavedSidebarState();
            applySidebarState(savedState);
        }
    });
    
    // Bootstrap tab functionality için eventListener
    var tabElms = document.querySelectorAll('[data-bs-toggle="list"]');
    if (tabElms.length > 0) {
        tabElms.forEach(function(tabElm) {
            tabElm.addEventListener('click', function(event) {
                event.preventDefault();
                var tab = new bootstrap.Tab(tabElm);
                tab.show();
            });
        });
    }

    // Form validation için eventListener
    var forms = document.querySelectorAll('.needs-validation');
    if (forms.length > 0) {
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }

    // Randevu takvim görünümü için tarih değişikliği
    var dateInputs = document.querySelectorAll('input[type="date"]');
    if (dateInputs.length > 0) {
        dateInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                console.log('Tarih değişti: ' + input.value);
                // Burada AJAX ile tarih değişikliğinde veri getirebilirsiniz
            });
        });
    }

    // Çıkış onayı
    var logoutLinks = document.querySelectorAll('a[href*="logout.php"]');
    if (logoutLinks.length > 0) {
        logoutLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                if (!confirm('Çıkış yapmak istediğinize emin misiniz?')) {
                    event.preventDefault();
                }
            });
        });
    }

    // Delete confirmation with different message based on element type
    document.addEventListener('click', function(event) {
        let target = event.target;
        
        // Traverse up to find closest .btn-danger or [data-confirm] element
        while (target && target !== document) {
            if (target.classList.contains('btn-danger') || target.hasAttribute('data-confirm')) {
                // Skip confirmation if explicitly set to false
                if (target.getAttribute('data-confirm') === 'false') {
                    return;
                }
                
                // Get custom message if available
                const message = target.getAttribute('data-confirm-message') || 
                                'Bu öğeyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.';
                
                if (!confirm(message)) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                return;
            }
            target = target.parentElement;
        }
    });
    
    // Toast notifications
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    const toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 5000
        });
    });
    
    // Show all toasts
    toastList.forEach(toast => toast.show());
    
    // Custom file input label
    const customFileInputs = document.querySelectorAll('.custom-file-input');
    if (customFileInputs.length > 0) {
        customFileInputs.forEach(function(input) {
            input.addEventListener('change', function(e) {
                const fileName = this.files[0].name;
                const label = this.nextElementSibling;
                label.innerText = fileName;
            });
        });
    }
    
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Enable popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Card expanding on hover animation
    const animatedCards = document.querySelectorAll('.card.animate-card');
    if (animatedCards.length > 0) {
        animatedCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('card-expanded');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('card-expanded');
            });
        });
    }
}); 