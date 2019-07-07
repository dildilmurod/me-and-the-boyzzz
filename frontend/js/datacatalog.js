
// const Http = new XMLHttpRequest();
// const url='http://dataplatform.000webhostapp.com/api/task';
// Http.open("GET", url);
// Http.send();
// Http.onreadystatechange = (e) => {
  // str=Http.responseText




// Create a request variable and assign a new XMLHttpRequest object to it.
const Http = new XMLHttpRequest()
const url='http://dataplatform.000webhostapp.com/api/task';
// Open a new connection, using the GET request on the URL endpoint
Http.open("GET", url);
Http.send();
var count;
var a=0;
Http.onreadystatechange = function(){
  if(this.readyState=4 && this.status==200){
 
     var str=Http.responseText
    var str1=str.substring(str.length-700,str.length)

    var pos = str1.indexOf('id');

    var los = str1.indexOf('title');
    count=str1.substring(pos+4,los-2);

    console.log(pos)  
    console.log(los)  



    if(a==2){

      var pos = str.indexOf('title');
var los = str.indexOf('file'); // 2
document.querySelector('#carda .card-title').innerHTML = str.substring(pos+8,los-3);


var pos = str.indexOf('description');
var los = str.indexOf('purpose'); // 2
document.querySelector('#carda .card-text').innerHTML=str.substring(pos+14,los-3)


var pos = str.indexOf('num_of_downloads');
var los = str.indexOf('description'); // 2
document.querySelector('#carda #list1').innerHTML=str.substring(pos+18,los-2)+' downloads'


var pos = str.indexOf('created_at');
var los = str.indexOf('updated_at'); // 2
document.querySelector('#carda #list2').innerHTML=str.substring(pos+13,los-3)


var pos = str.indexOf('file');
var los = str.indexOf('filesize'); // 2

var str1=str.substring(str.indexOf('updated_at')+38,str.length)
document.querySelector('#carda #list3').innerHTML=str.substring(pos+7,los-3)
var i,value;
console.log(count)
for(i=0,value=0;i<count;i++,value=value+str1.indexOf('id')+1){
  if(i%6==0){
 str1=str1.substring(value-250,str1.length);

  }
    else{
 str1=str1.substring(value-10,str1.length);}
console.log(i)
console.log(str1)
  
 var itm = document.getElementById("carda");
 var cln = itm.cloneNode(true);
 cln.id='card'+i;

 document.getElementById("row1").appendChild(cln);
$('#'+cln.id).parents().find('.card-link').id=i;
 var car='#card'+i.toString();


 var pos = str1.indexOf('title');
 var los = str1.indexOf('file'); // 2
 document.querySelector(car+' .card-title').innerHTML = str1.substring(pos+8,los-3);


var pos = str1.indexOf('description');
var los = str1.indexOf('purpose'); // 2
document.querySelector(car+' .card-text').innerHTML=str1.substring(pos+14,los-3)

var pos = str1.indexOf('num_of_downloads');
var los = str1.indexOf('description'); // 2
document.querySelector(car+' #list1').innerHTML=str1.substring(pos+18,los-2)+' downloads'


var pos = str1.indexOf('created_at');
var los = str1.indexOf('updated_at'); // 2
document.querySelector(car+' #list2').innerHTML=str1.substring(pos+13,los-3)


var pos = str1.indexOf('file');
var los = str1.indexOf('filesize'); // 2
document.querySelector(car+' #list3').innerHTML=str1.substring(pos+7,los-3)
// $('#'+cln.id).parents().find('.card-link').href+=str1.substring(pos+7,los-3);
// console.log('#'+cln.id+' .card-link')
// document.getElementById().href=;
var element = document.querySelector('#'+cln.id+' .card-link');
    element.href = 'http://dataplatform.000webhostapp.com/files/'+str1.substring(pos+7,los-3)
}
}
a++;
}
}

// $('.card-link').click(function(e) {
//          var url = "http://dataplatform.000webhostapp.com/files/"+$('.card-link').parents().parents().find('#list3').html();
//           e.preventDefault(); 
//          window.location.href = url;
// });

 // $.myjQuery = function() {
 //         // var url = "http://dataplatform.000webhostapp.com/files/"+$('.card-link').parents().parents().find('#list3').html();
 //         // window.location.href = url;
 //         console.log($('.card-link').parents().parents().find('#list3').html())
 //         };
 //         function display() {
 //            $.myjQuery();
 //         };



 document.getElementById('userLogin').innerHTML = localStorage.getItem('1');
 
