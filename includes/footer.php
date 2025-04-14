    <?php if (isset($_SESSION['user_id'])): ?>
            </div> <!-- main-content end -->
        </div> <!-- content-wrapper end -->
    </div> <!-- wrapper end -->
    
    <footer class="footer">
        <div class="container">
            <span>© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tüm hakları saklıdır.</span>
        </div>
    </footer>
    <?php else: ?>
    </div> <!-- container end -->
    
    <footer class="footer mt-5 py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tüm hakları saklıdır.</span>
        </div>
    </footer>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html> 