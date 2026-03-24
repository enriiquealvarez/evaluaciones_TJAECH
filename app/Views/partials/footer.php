</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <span>TJAECH · Sistema de Evaluación de Capacitaciones</span>
        <span><?= date('Y') ?> · Gobierno del Estado</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', (event) => {
      if (!window.Swal) {
        return;
      }
      event.preventDefault();
      const title = form.dataset.confirmTitle || '¿Confirmar acción?';
      const text = form.dataset.confirm || '¿Deseas continuar?';
      const confirmText = form.dataset.confirmOk || 'Aceptar';
      const cancelText = form.dataset.confirmCancel || 'Cancelar';
      const icon = form.dataset.confirmIcon || 'warning';
      const confirmColor = form.dataset.confirmColor || '#AC986A';
      const cancelColor = form.dataset.confirmCancelColor || '#111426';
      Swal.fire({
        title,
        text,
        icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor
      }).then(result => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  document.querySelectorAll('.alert[data-swal]').forEach(alert => {
    if (!window.Swal) {
      return;
    }
    const icon = alert.dataset.swal || 'success';
    const title = alert.dataset.swalTitle || (icon === 'success' ? 'Listo' : 'Atención');
    const text = alert.textContent.trim();
    const confirmColor = alert.dataset.swalColor || (icon === 'success' ? '#009482' : '#D8065B');
    Swal.fire({
      icon,
      title,
      text,
      confirmButtonText: 'Aceptar',
      confirmButtonColor: confirmColor
    });
    alert.remove();
  });
</script>
</body>
</html>
