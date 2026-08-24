import './bootstrap';
import 'bootstrap';

const propertySearch = document.querySelector('#property-search');
const propertyOptions = [...document.querySelectorAll('.property-option')];
const propertyNoResults = document.querySelector('#property-no-results');
const propertyList = document.querySelector('#property-list');
const propertySearchHint = document.querySelector('#property-search-hint');
const propertyForm = document.querySelector('#property-step');
const complaintForm = document.querySelector('#complaint-step');
const areaForm = document.querySelector('#area-step');
const permissionForm = document.querySelector('#permission-step');
const uploadForm = document.querySelector('#upload-step');
const personalForm = document.querySelector('#personal-step');
let selectedProperty = null;
let selectedComplaint = null;

propertySearch?.addEventListener('input', ({ target }) => {
	const query = target.value.trim().toLowerCase();
	let visibleCount = 0;
	const hasQuery = query.length > 0;

	propertyList?.classList.toggle('d-none', !hasQuery);
	propertySearchHint?.classList.toggle('d-none', hasQuery);

	propertyOptions.forEach((property) => {
		const isMatch = property.dataset.property.includes(query);
		property.classList.toggle('d-none', !isMatch);
		visibleCount += isMatch ? 1 : 0;
	});

	propertyNoResults?.classList.toggle('d-none', !hasQuery || visibleCount > 0);
});

propertyOptions.forEach((property) => {
	property.addEventListener('click', () => {
		selectedProperty = property;
		propertyOptions.forEach((option) => option.classList.remove('selected'));
		property.classList.add('selected');
		document.querySelector('#property-value').value = property.dataset.address;
		document.querySelector('#selected-property').textContent = property.dataset.address;
		document.querySelector('#area-selected-property').textContent = property.dataset.address;
		document.querySelector('#complaint-property-value').value = property.dataset.address;
		document.querySelector('#area-property-value').value = property.dataset.address;
		propertyForm.classList.add('d-none');
		complaintForm.classList.remove('d-none');
		complaintSearch?.focus();
	});
});

const complaintSearch = document.querySelector('#complaint-search');
const complaintOptions = [...document.querySelectorAll('.complaint-option')];
const complaintNoResults = document.querySelector('#complaint-no-results');
const areaSearch = document.querySelector('#area-search');
const areaOptions = [...document.querySelectorAll('.area-option')];
const areaNoResults = document.querySelector('#area-no-results');

complaintSearch?.addEventListener('input', ({ target }) => {
	const query = target.value.trim().toLowerCase();
	let visibleCount = 0;

	complaintOptions.forEach((complaint) => {
		const isMatch = complaint.dataset.complaint.includes(query);
		complaint.classList.toggle('d-none', !isMatch);
		visibleCount += isMatch ? 1 : 0;
	});

	complaintNoResults?.classList.toggle('d-none', visibleCount > 0);
});

complaintOptions.forEach((complaint) => {
	complaint.addEventListener('click', () => {
		selectedComplaint = complaint.dataset.value;
		complaintOptions.forEach((option) => option.classList.remove('selected'));
		complaint.classList.add('selected');
		document.querySelector('#complaint-value').value = selectedComplaint;
		document.querySelector('#selected-complaint').textContent = selectedComplaint;
		document.querySelector('#area-complaint-value').value = selectedComplaint;
		document.querySelector('#selected-complaint-choice').textContent = `Selected complaint: ${selectedComplaint}`;
		document.querySelector('#selected-complaint-choice').classList.remove('d-none');
		complaintForm.classList.add('d-none');
		areaForm.classList.remove('d-none');
		areaSearch?.focus();
	});
});

document.querySelector('#complaint-back')?.addEventListener('click', () => {
	complaintForm.classList.add('d-none');
	propertyForm.classList.remove('d-none');
	propertySearch?.focus();
});

areaSearch?.addEventListener('input', ({ target }) => {
	const query = target.value.trim().toLowerCase();
	let visibleCount = 0;

	areaOptions.forEach((area) => {
		const isMatch = area.dataset.area.includes(query);
		area.classList.toggle('d-none', !isMatch);
		visibleCount += isMatch ? 1 : 0;
	});

	areaNoResults?.classList.toggle('d-none', visibleCount > 0);
});

areaOptions.forEach((area) => {
	area.addEventListener('click', () => {
		areaOptions.forEach((option) => option.classList.remove('selected'));
		area.classList.add('selected');
		document.querySelector('#area-value').value = area.textContent;
		document.querySelector('#permission-selected-area').textContent = area.textContent;
		document.querySelector('#permission-property-value').value = document.querySelector('#area-property-value').value;
		document.querySelector('#permission-complaint-value').value = document.querySelector('#area-complaint-value').value;
		document.querySelector('#permission-area-value').value = area.textContent;
		const selectedArea = document.querySelector('#selected-area');
		selectedArea.textContent = `Selected area: ${area.textContent}`;
		selectedArea.classList.remove('d-none');
		areaForm.classList.add('d-none');
		permissionForm.classList.remove('d-none');
		document.querySelector('#reporter-name')?.focus();
	});
});

document.querySelector('#area-back')?.addEventListener('click', () => {
	areaForm.classList.add('d-none');
	complaintForm.classList.remove('d-none');
	complaintSearch?.focus();
});

document.querySelector('#permission-back')?.addEventListener('click', () => {
	permissionForm.classList.add('d-none');
	areaForm.classList.remove('d-none');
	areaSearch?.focus();
});

document.querySelectorAll('.permission-option').forEach((permission) => {
	permission.addEventListener('click', () => {
		document.querySelectorAll('.permission-option').forEach((option) => option.classList.remove('selected'));
		permission.classList.add('selected');
		document.querySelector('#spare-key-value').value = permission.dataset.permission;
		document.querySelector('#selected-permission').textContent = `Spare key permission: ${permission.dataset.permission}`;
		document.querySelector('#selected-permission').classList.remove('d-none');
		document.querySelector('#permission-next').disabled = false;
	});
});

permissionForm?.addEventListener('submit', (event) => {
	event.preventDefault();
	document.querySelector('#upload-property-value').value = document.querySelector('#permission-property-value').value;
	document.querySelector('#upload-complaint-value').value = document.querySelector('#permission-complaint-value').value;
	document.querySelector('#upload-area-value').value = document.querySelector('#permission-area-value').value;
	document.querySelector('#upload-permission-value').value = document.querySelector('#spare-key-value').value;
	document.querySelector('#upload-remark-value').value = document.querySelector('#spare-key-remark').value;
	permissionForm.classList.add('d-none');
	uploadForm.classList.remove('d-none');
});

document.querySelector('#upload-back')?.addEventListener('click', () => {
	uploadForm.classList.add('d-none');
	permissionForm.classList.remove('d-none');
});

const mediaFiles = document.querySelector('#media-files');
const mediaPreview = document.querySelector('#media-preview');
const uploadError = document.querySelector('#upload-error');
const uploadNext = document.querySelector('#upload-next');
let selectedFiles = [];

mediaFiles?.addEventListener('change', ({ target }) => {
	const files = [...target.files];
	uploadError.classList.add('d-none');
	if (selectedFiles.length + files.length > 10) {
		uploadError.textContent = 'You can upload a maximum of 10 files.';
		uploadError.classList.remove('d-none');
		target.value = '';
		return;
	}
	selectedFiles = [...selectedFiles, ...files];
	renderPreviews();
});

function renderPreviews() {
	mediaPreview.innerHTML = '';
	selectedFiles.forEach((file, index) => {
		const item = document.createElement('div');
		item.className = 'media-item';
		const media = document.createElement(file.type.startsWith('video/') ? 'video' : 'img');
		media.src = URL.createObjectURL(file);
		media.controls = file.type.startsWith('video/');
		media.alt = file.name;
		const remove = document.createElement('button');
		remove.type = 'button';
		remove.className = 'media-remove';
		remove.textContent = 'Remove';
		remove.addEventListener('click', () => {
			selectedFiles.splice(index, 1);
			renderPreviews();
		});
		item.append(media, remove);
		mediaPreview.appendChild(item);
	});
	uploadNext.disabled = selectedFiles.length === 0;
}

uploadForm?.addEventListener('submit', (event) => {
	event.preventDefault();
	personalForm.classList.remove('d-none');
	uploadForm.classList.add('d-none');
	document.querySelector('#personal-property-value').value = document.querySelector('#upload-property-value').value;
	document.querySelector('#personal-complaint-value').value = document.querySelector('#upload-complaint-value').value;
	document.querySelector('#personal-area-value').value = document.querySelector('#upload-area-value').value;
	document.querySelector('#personal-permission-value').value = document.querySelector('#upload-permission-value').value;
	document.querySelector('#personal-remark-value').value = document.querySelector('#upload-remark-value').value;
	document.querySelector('#first-name')?.focus();
});

document.querySelector('#personal-back')?.addEventListener('click', () => {
	personalForm.classList.add('d-none');
	uploadForm.classList.remove('d-none');
});

personalForm?.addEventListener('submit', (event) => {
	event.preventDefault();
	document.querySelector('#submit-message').classList.remove('d-none');
});

areaForm?.addEventListener('submit', (event) => {
	event.preventDefault();
});
