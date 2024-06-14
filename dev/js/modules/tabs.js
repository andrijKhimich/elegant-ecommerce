const openTab = (evt, tabName) => {
	let i, tabContent, tabLinks;
	tabContent = document.querySelectorAll('.js-tab-content');
	for (i = 0; i < tabContent.length; i++) {
		tabContent[i].classList.remove('active');
	}
	tabLinks = document.querySelectorAll('.tab__link');
	for (i = 0; i < tabLinks.length; i++) {
		tabLinks[i].classList.remove('active');
	}
	document.getElementById(tabName).classList.add('active');
	evt.currentTarget.classList.add('active');
};

export const toggleTab = () => {
	document.addEventListener('DOMContentLoaded', () => {
		const tabBtns = document.querySelectorAll('.tab__link');
		tabBtns.forEach((tabBtn) => {
			tabBtn.addEventListener('click', (e) => {
				let target = e.currentTarget.getAttribute('data-href');
				openTab(e, target);
			});
		});
	});
};
