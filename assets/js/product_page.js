console.log('bonjour');

let imgSliderContainer = document.querySelector('.img-list-container');

if (window.innerWidth > 1200) {
imgSliderContainer.classList.remove('d-none')
} else {
imgSliderContainer.classList.add('d-none')
}


const resize = (e) => {
if (window.innerWidth > 1200) {
e.preventDefault();
imgSliderContainer.classList.remove('d-none')
} else {
e.preventDefault();
imgSliderContainer.classList.add('d-none')
}
}
window.addEventListener('resize', resize)
let modalActivator = document.querySelectorAll('img');
let img = document.querySelectorAll('.img-list-container > img');
let arrayImg = Array.from(img);
let cursor = 0;

const container = document.querySelector('.principal-container');
const rightButton = document.querySelector('.right-row');
const leftButton = document.querySelector('.left-row');
let modals = document.querySelectorAll('[data-modal]');

modals.forEach(function (trigger) {

trigger.addEventListener('click', function (e) {
e.preventDefault();

const modal = document.getElementById(trigger.dataset.modal);
modal.setAttribute('style', "visibility:visible ")
const close = modal.querySelectorAll('.close-button');
close.forEach(function (exit) {
exit.addEventListener('click', function (event) {
event.preventDefault();
modal.setAttribute('style', "visibility:hidden")
})
})
})
})


let attribute = arrayImg[cursor].getAttribute('src');
principalImg = document.createElement('img');
principalImg.setAttribute('src', attribute);
principalImg.setAttribute('class', 'primary-image my-auto mx-auto');
container.insertBefore(principalImg, rightButton);


const blurImages = () => {

arrayImg.forEach(img => img.style.opacity = '0.3');
}


const moveLeft = () => {

cursor--;
blurImages();
if (cursor < 0) {
cursor = arrayImg.length - 1;
}
attribute = arrayImg[cursor].getAttribute('src');
principalImg.setAttribute('src', attribute);
arrayImg[cursor].style.opacity = '1';
}

const moveRight = () => {

cursor++;
blurImages();
if (cursor > arrayImg.length - 1) {
cursor = 0;
}
attribute = arrayImg[cursor].getAttribute('src');
principalImg.setAttribute('src', attribute);
arrayImg[cursor].style.opacity = '1';} 

leftButton.addEventListener('click', moveLeft);
rightButton.addEventListener('click', moveRight);

arrayImg.forEach((img, index) => {
img.addEventListener('click', (e) => {


principalImg.setAttribute('src', img.getAttribute('src'));
blurImages();
img.style.opacity = '1';
cursor = index;
})
})