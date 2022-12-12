
let deleteImg = document.querySelectorAll('#delete');
deleteImg.forEach((trigger) => {
	trigger.addEventListener('click', (e) => {
		e.preventDefault();
		let id = trigger.getAttribute('value');
		const param = new URLSearchParams();
		const url = window.location;
		param.append('idImage' , id );
		console.log(url.pathname);
		fetch(url.pathname + "?" + param + "&ajax=1",
		{
			header:
			{"X-Requested-With": "XMLHttpRequest"}
		})
		
		image = document.querySelectorAll('img[value]');

		image.forEach((img) => {
		if(img.getAttribute('value') == id)
		{
			let parent = img.parentNode;
			parent.classList.add('d-none');
		}

		})
		
	
		

	})
})












$(document).ready(function() {
    $('.select2').select2();
});
////////////////////////////// CREATE NEW FILE INPUT

const newItem = (e) => {
const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);
const item = document.createElement('div');
item.classList.add('col-4');
item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g, collectionHolder.dataset.index);
item.querySelector('.btn-remove').addEventListener('click', () => item.remove());
collectionHolder.appendChild(item);
collectionHolder.dataset.index ++;
}

document.querySelectorAll('.btn-new').forEach(btn => btn.addEventListener('click', newItem));