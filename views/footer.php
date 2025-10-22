<?php
?>
</main>
<script src="<?= h(base_url('js/app.js')) ?>"></script>

<?php
if (basename($_SERVER['SCRIPT_NAME']) !== 'login_error.php') {
    if (!empty($_SESSION['flash_error'])) {
        echo '<script>alert("' . addslashes($_SESSION['flash_error']) . '");</script>';
        unset($_SESSION['flash_error']);
    }
    if (!empty($_SESSION['flash_success'])) {
        echo '<script>alert("' . addslashes($_SESSION['flash_success']) . '");</script>';
        unset($_SESSION['flash_success']);
    }
}
?>
</body>
</html>
