



function cambiar_login() {
	document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_login";
	document.querySelector('.cont_form_login').style.display = "block";
	document.querySelector('.cont_form_sign_up').style.opacity = "0";

	setTimeout(function() {
		document.querySelector('.cont_form_login').style.opacity = "1";
	}, 400);

	setTimeout(function() {
		document.querySelector('.cont_form_sign_up').style.display = "none";
	}, 200);
}

function cambiar_sign_up(at) {
	document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_sign_up";
	document.querySelector('.cont_form_sign_up').style.display = "block";
	document.querySelector('.cont_form_login').style.opacity = "0";

	setTimeout(function() {
		document.querySelector('.cont_form_sign_up').style.opacity = "1";
	}, 100);

	setTimeout(function() {
		document.querySelector('.cont_form_login').style.display = "none";
	}, 400);

}

function ocultar_login_sign_up() {

	document.querySelector('.cont_forms').className = "cont_forms";
	document.querySelector('.cont_form_sign_up').style.opacity = "0";
	document.querySelector('.cont_form_login').style.opacity = "0";

	setTimeout(function() {
		document.querySelector('.cont_form_sign_up').style.display = "none";
		document.querySelector('.cont_form_login').style.display = "none";
	}, 500);

}

function enable_radio(a) {
	if(a=='off'){
		document.querySelector('.turnon0').disabled=true;
		document.querySelector('.turnon1').disabled=true;
		document.querySelector('.turnon2').disabled=true;
		document.querySelector('.turnon3').disabled=true;
		document.querySelector('.turnon4').disabled=true;

	}else{
		document.querySelector('.turnon0').disabled=false;
		document.querySelector('.turnon1').disabled=false;
		document.querySelector('.turnon2').disabled=false;
		document.querySelector('.turnon3').disabled=false;
		document.querySelector('.turnon4').disabled=false;
	}

}
var hello = "ad";
function UserLogin() {
	if(document.querySelector('#loginss').value==="" || document.querySelector('#passwordss').value===""){
		document.querySelector('#valid').style.opacity=1;
	}
	else{


		let user=document.querySelector('#loginss').value
		hello = user;
		
		
		let pass=document.querySelector('#passwordss').value
		const Url = 'http://dataplatform.000webhostapp.com/api/physical-login';
		const data = {
			username: user,
			password: pass
		}
		

		console.log(data.username);
		
		var te = data.username;
		localStorage.setItem('1', te)
		
		console.log(localStorage.getItem('1'))
		$.post(Url,data,function(data,status){
			console.log(data.msg)
			if(data.msg==='success'){
				console.log(hello)

				document.querySelector('#valid').style.opacity=1;
				document.querySelector('#valid').innerHTML="Welcome";
				window.location.replace("../datacatalog.html");
				
			}
		});
	} 
}

function UserRegister() {
	if (document.getElementById('user_name_surname').value=="") {
		document.getElementById('err_fio').innerHTML='Введите имя и фамилию';
	}
	else if (document.getElementById('user_login').value=="") {
		document.getElementById('err_fio').innerHTML='Введите логин';
	}
	else if (document.getElementById('user_password').value=="") {
		document.getElementById('err_fio').innerHTML='Введите пароль';
	}
	else if (document.getElementById('user_password_re').value=="") {
		document.getElementById('err_fio').innerHTML='Введите повторно пароль';
	}
	else if (document.getElementById('user_password_re').value != document.getElementById('user_password').value){
		document.getElementById('err_fio').innerHTML='Пароли не совпадают';
	}
	else{
		if(document.querySelector('#user_face').checked){
			if (document.getElementById('turnon0').value=="") {
				document.getElementById('err_fio').innerHTML='Введите ИИН/БИН';
			}
			else if (document.getElementById('turnon1').value=="") {
				document.getElementById('err_fio').innerHTML='Введите контактный телефон';
			}
			else if (document.getElementById('turnon2').value=="") {
				document.getElementById('err_fio').innerHTML='Введите наименование';
			}
			else if (document.getElementById('turnon3').value=="") {
				document.getElementById('err_fio').innerHTML='Введите номер регистрации';
			}
			else if (document.getElementById('turnon4').value=="") {
				document.getElementById('err_fio').innerHTML='Введите страну';
			}
			else{
				const Url = 'http://dataplatform.000webhostapp.com/api/physical-register';

				let username1=document.querySelector('#user_login').value
				console.log(username1);
				let name1=document.querySelector('#user_name_surname').value
				let password1=document.querySelector('#user_password').value
				let role_id1=0;
				if(document.querySelector('#user_password').checked){
					let role_id1=1;

				}

				const data = {
					username: username1,
					name:name1,
					password: password1,
					role_id:role_id1
				}
				$.post(Url,data,function(data,status){
					console.log(data.message)
					document.getElementById('err_fio').innerHTML=data.message;
					window.location.replace("../datacatalog.html");
				});
			}

		}
		else{
			const Url = 'http://dataplatform.000webhostapp.com/api/physical-register';

			let username1=document.querySelector('#user_login').value
		
			let name1=document.querySelector('#user_name_surname').value
			let password1=document.querySelector('#user_password').value
			let role_id1=0;
			if(document.querySelector('#user_password').checked){
				let role_id1=1;

			}

			const data = {
				username: username1,
				name:name1,
				password: password1,
				role_id:role_id1
			}
			var teе = data.username;
			localStorage.setItem('1', teе)
			$.post(Url,data,function(data,status){
				console.log(data.message)
				document.getElementById('err_fio').innerHTML=data.message;
				window.location.replace("../datacatalog.html");
			});
		}
	}

	

}




