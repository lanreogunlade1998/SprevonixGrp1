const navToggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.site-nav');
if (navToggle && nav) {
  navToggle.addEventListener('click', () => nav.classList.toggle('open'));
}

const sanitize = (value) => String(value || '').replace(/[<>]/g, '').trim();

const form = document.getElementById('contactForm');
if (form) {
  const formMessage = document.getElementById('formMessage');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    // Client-side validation (kept exactly as before)
    const fullName = sanitize(formData.get('fullName'));
    const email = sanitize(formData.get('email'));
    const service = sanitize(formData.get('service'));
    const requestType = sanitize(formData.get('requestType'));
    const message = sanitize(formData.get('message'));

    if (!fullName || !email || !service || !requestType || !message) {
      formMessage.textContent = 'Please complete all required fields.';
      formMessage.style.color = '#c62828';
      return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      formMessage.textContent = 'Please provide a valid email address.';
      formMessage.style.color = '#c62828';
      return;
    }

    try {
      const response = await fetch('insert.php', {
        method: 'POST',
        body: formData
      });

      const resultText = await response.text();

      if (response.ok && resultText.includes('successfully')) {
        form.reset();
        formMessage.textContent = 'Your request has been submitted successfully.';
        formMessage.style.color = '#0f9d58';
      } else {
        formMessage.textContent = 'Error: ' + resultText;
        formMessage.style.color = '#c62828';
      }
    } catch (err) {
      formMessage.textContent = 'Network error – please try again.';
      formMessage.style.color = '#c62828';
    }
  });
}
