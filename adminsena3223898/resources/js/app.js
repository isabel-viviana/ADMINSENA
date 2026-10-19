import './bootstrap';

document.querySelectorAll('[data-search-trigger]').forEach((trigger) => {
	trigger.addEventListener('click', () => {
		const drawer = document.querySelector('[data-search-drawer]');
		drawer.classList.add('is-open');
		drawer.setAttribute('aria-hidden', 'false');
		drawer.querySelector('input').focus();
	});
});

document.querySelectorAll('[data-search-close]').forEach((close) => {
	close.addEventListener('click', () => {
		const drawer = document.querySelector('[data-search-drawer]');
		drawer.classList.remove('is-open');
		drawer.setAttribute('aria-hidden', 'true');
	});
});
