/**
 * Randeva Main JavaScript Functions
 */

document.addEventListener('DOMContentLoaded', function() {
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

    // Silme işlemi onayı
    var deleteButtons = document.querySelectorAll('.btn-danger');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                if (!confirm('Bu öğeyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')) {
                    event.preventDefault();
                }
            });
        });
    }
}); 