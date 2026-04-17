var ip;

$(function(){
   
   const socket = io('http://192.168.3.5:8989');
   
   socket.on('yip',function(data){
	   ip = data;
   });
   
   socket.on('stime',function(data){
	   if(data.run=='close'){
		   if(data.from==ip){
		      window.location.href="http://192.168.3.5/rekrutmen/Welcome/logout";	   
		   }
	   }
   });
	 
});