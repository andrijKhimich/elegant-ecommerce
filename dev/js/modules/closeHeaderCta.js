
export const closeHeaderCta = () => {
  const closeBtn = document.querySelector('.js-header-cta-btn');
  const headerCta = document.querySelector('.js-header-cta');
  closeBtn.addEventListener('click', () => {
    headerCta.classList.add('hidden');
  })
}