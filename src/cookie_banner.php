<!-- COOKIE CONSENT MODAL -->
<div class="modal fade" id="cookieconsent2" tabindex="-1"
     aria-labelledby="cookieconsentLabel2" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="cookieconsentLabel2">Cookies & Confidentialité</h5>

        <!-- Хрестик є, але modal не закриється через static backdrop + keyboard false,
             але користувач може натиснути його — якщо хочеш повністю заборонити, просто видали цю кнопку -->
        <button type="button" class="btn-close" aria-label="Close" onclick="refuseCookies()"></button>
      </div>

      <div class="modal-body">
        <p>
          Ce site utilise des cookies afin de vous garantir la meilleure expérience possible.
          <a class="d-block" href="#" style="color:#C66D25;">En savoir plus sur les cookies</a>
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" onclick="refuseCookies()">
          Refuser
        </button>

        <button type="button" class="btn btn-primary" onclick="acceptCookies()">
          Accepter
        </button>
      </div>

    </div>
  </div>
</div>

<script>
  // Читає cookie за назвою
  function getCookie(name) {
    const cookies = document.cookie ? document.cookie.split("; ") : [];
    for (let c of cookies) {
      const parts = c.split("=");
      const key = parts.shift();
      const value = parts.join("=");
      if (key === name) return decodeURIComponent(value);
    }
    return null;
  }

  // Ставить cookie на N днів
  function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie =
      name + "=" + encodeURIComponent(value) +
      "; expires=" + d.toUTCString() +
      "; path=/; SameSite=Lax";
  }

  // Показ модалки тільки якщо cookie ще НЕ прийняті
  document.addEventListener("DOMContentLoaded", function () {
    const consent = getCookie("cookie_consent");

    if (consent !== "accepted") {
      // Перевірка: чи bootstrap JS точно підключений
      if (typeof bootstrap === "undefined" || !bootstrap.Modal) {
        console.log("Bootstrap JS not loaded: cookie modal cannot open.");
        return;
      }

      const modalEl = document.getElementById("cookieconsent2");
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
    }
  });

  // Accept = записуємо cookie і закриваємо
  function acceptCookies() {
    setCookie("cookie_consent", "accepted", 180);
    const modalEl = document.getElementById("cookieconsent2");
    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.hide();
  }

  // Refuse = не закриваємо
  function refuseCookies() {
    alert("Vous devez accepter les cookies pour continuer la navigation.");
  }
</script>
