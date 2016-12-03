
	               function goToBegin(){
	               	document.getElementById( id2).style.backgroundImage="url('backimg.jpeg')";
	               		document.getElementById( id1).style.backgroundImage="url('backimg.jpeg')";
	             i=1
		 MAX = 40;
		 blue = 17;
		 red=37;
		 bluerun=0;
		 redrun=0;
		 main = document.getElementById("main");

		
			id1="b"+blue;
			document.getElementById( id1).style.background="blue";// }
			 id2="b"+red;
			document.getElementById( id2).style.background="red";// }
					
		
	}
                            
                          function shaizi(){
                          	document.getElementById("idshaizi") .style.backgroundImage="url('img1.jpg')";
               


                                     
                          }

                              i=1
		 MAX = 40;
		 blue = 17;
		 red=37;
		 bluerun=0;
		 redrun=0;
		 main = document.getElementById("main");

		
		window.onload=function(){
			id1="b"+blue;
			document.getElementById( id1).style.background="blue";// }
			 id2="b"+red;
			document.getElementById( id2).style.background="red";// }
					
		}

		function roll(){
		if(i==1){i=2;
			 result = Math.floor(Math.random()*6+1);
			num=result;
			 shaizi();
			document.getElementById("happen") .innerHTML= "<br> " ;
			//产生随机数
			document.getElementById("roll-result") .innerHTML= "蓝格子roll到的是:" + result;
			document.getElementById("huihe") .innerHTML= "下一行动者：红格子" ;

			console.log(result);
			id1="b"+blue;
			document.getElementById( id1).style.backgroundImage="url('backimg.jpeg')";
 		             
			blue += result;
			if (blue ==38||blue==25) {

				blue=blue+6;
				if(blue>MAX){
				blue -= MAX;
				bluerun=bluerun +1;
			             }

			             id1="b"+blue;
			            document.getElementById("happen") .innerHTML= "蓝格子飞行6格" ;

			}

			if (blue ==12||blue==15) {

				blue=blue-result;
		                           id1="b"+blue;
			            document.getElementById("happen") .innerHTML= "蓝格子踩中unlucky，退回原位" ;

			}
		
			if(blue>MAX){
				blue -= MAX;
				bluerun=bluerun +1;
			}
			
			 id1="b"+blue;
			
			document.getElementById( id1).style.background="blue";
			//7-8
			if((redrun*40+red-37)>=200||(bluerun*40+blue)<=(redrun*40+red-40)) {
                                      alert("红格子胜利");
                                       window.close();

                                      }
                                     if ((bluerun*40+blue-17)>=200||(bluerun*40+blue)>=(redrun*40+red)) {
                                     alert("蓝格子胜利");
                                       window.close();

                                      } 
                               //待完善
                                  if (blue==5||blue==33) {
                                  	i=1;
                                       document.getElementById("huihe") .innerHTML= "下一行动者：蓝格子" ;                               	
		            document.getElementById("happen") .innerHTML= "蓝格子奖励一次" ;
                                   }
                               //7-9
                          }
			
		

		else{    i=1;
			document.getElementById("happen") .innerHTML= "<br> " ;
			 result = Math.floor(Math.random()*6+1);
			num=result;
			 shaizi();

			//产生随机数
			document.getElementById("roll-result") .innerHTML= "红格子roll到的是:" + result;
			document.getElementById("huihe") .innerHTML= "下一行动者：蓝格子" ;

			console.log(result);
			 id2="b"+red;
			document.getElementById( id2).style.backgroundImage="url('backimg.jpeg')";
			red += result;
			if (red ==38||red==25) {
				red=red+6;
			             id2="b"+red;
			            if(red>MAX){
				red -= MAX;
				redrun=redrun+1;
			          }
			           id2="b"+red;

			            document.getElementById("happen") .innerHTML= "红格子飞行6格" ;
			}
			if (red ==12||red==15) {

				red=red-result;
		                           id2="b"+red;
			            document.getElementById("happen") .innerHTML= "红格子踩中unlucky，退回原位" ;

			}
		


			if(red>MAX){
				red -= MAX;
				redrun=redrun+1;
			}
			 id2="b"+red;
			document.getElementById( id2).style.background="red";
  			if ((redrun*40+red-37)>=200||(bluerun*40+blue)<=(redrun*40+red-40)) {
                                    alert("红格子胜利");
                                    window.close();
                                      }
                                     if ((bluerun*40+blue-17)>=200||(bluerun*40+blue)>=(redrun*40+red)) {
                                    alert("蓝格子胜利");
                                       window.close();
                                    } 
                                  if (red==5||red==33) {
                                  	i=2;
                                       document.getElementById("huihe") .innerHTML= "下一行动者：红格子" ;                               	
		            document.getElementById("happen") .innerHTML= "红格子奖励一次" ;
                                   }

 		}
	}	 
