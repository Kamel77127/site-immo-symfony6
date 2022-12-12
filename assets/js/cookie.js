const buttonCookieSeeMore = document.querySelectorAll('.cookie-see-more');
const buttonNoCookies = document.querySelector('.no-cookies');
const buttonAcceptCookies = document.querySelectorAll('.accept-cookie-button');
const moreDetails = document.getElementById('see-more');
const modal = document.querySelector('.bg-modal');
let checkbox = document.querySelector('.check-1');
let cookieArr = document.cookie.split(";");


function getCookie(cookie) {
    let cookieArr = document.cookie.split(";");
    for(let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if(cookie == cookiePair[0].trim()) {
            return cookiePair[1];
        }
    }
    return null;
}

function checkCookie() {
    let cookies = getCookie("cookies");
    if (cookies == 'true') {
        modal.classList.add('d-none');
    }else if(cookies == null || cookies == 'false'){
        modal.classList.remove('d-none');
      }
    }
  
  checkCookie();

buttonCookieSeeMore.forEach(function(trigger)
{
	trigger.addEventListener('click', (e) => {
		e.preventDefault();
		moreDetails.classList.remove('d-none');

	})
})

buttonNoCookies.addEventListener('click', (e) => {
	e.preventDefault();
	modal.classList.add('d-none');
})

buttonAcceptCookies.forEach((trigger)=> {

	trigger.addEventListener('click', (e) => {

	e.preventDefault();

    if(checkbox.checked)
    {
        
        $status = "accepted";
    }else {
       
        $status = "rejected";
    }
	const param = new URLSearchParams();
	param.append('cookie', $status);
	const url = new URL(window.location.href);
	fetch(url.pathname + "?" + param + "&ajax=1", {
		header: {
			"X-Requested-With": "XMLHttpRequest"
		}
	})
	modal.classList.add('d-none');


	})
	
})