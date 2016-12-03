document.getElementById(0).innerHTML="<img src=人1-上.jpg >";
document.getElementById(49).innerHTML="<img src=人2-上.jpg >";

var yiwei=0;
var a;
var erwei=31;
var quanshu=0;
var bing1=0;
var bing2=0;
var jin;
var tui;
var yibu=0;
var erbu=0;
var AP=1;
var loca;
var step;
var pd=0;

function chongzhi(){
                       yiwei=0;
                       erwei=31;
                       yibu=0;
                       erbu=0;
                       quanshu=0;
                       bing1=0;
                       bing2=0;

}



function act(){
        if(AP==1){
          loca=yiwei;
          step=yibu;
        }
        else if(AP==2){
          loca=erwei;
          step=erbu;
          document.getElementById(49).innerHTML="";
        }                   

        a=Math.floor(Math.random()*6+1);
        alert("你得到的点数是"+a);
          
        document.getElementById(loca).innerHTML="";
             
             loca=a+loca;
             step=a+step;
        if(AP==1){
          yiwei=yiwei+a;
          yibu=yibu+a;
        }
        else if(AP==2){
          erbu=erbu+a;
          erwei=erwei+a;
        }

      if(loca==7||loca==21||loca==43||loca==30){
             document.getElementById(loca).innerHTML="<img src=人"+AP+"-中.jpg >";
       }
       else if(loca==14){
             tui=Math.floor(Math.random()*6+1);
             loca=loca-tui;
             step=step-tui;
             if(AP==1){
                  yiwei=yiwei-tui;
                  yibu=yibu-tui;
              }
              else if(AP==2){
                  erbu=erbu-tui;
                  erwei=erwei-tui;
              }
             alert("您退后了"+tui+"步");
             document.getElementById(loca).innerHTML="<img src=人"+AP+"-右.jpg >";               
       }
       else if(loca==36){
              jin=Math.floor(Math.random()*6+1);
              loca=loca+jin;
              alert("您前进了"+jin+"步");
              step=step+jin;
               if(AP==1){
                  yiwei=yiwei+jin;
                  yibu=yibu+jin;
              }
              else if(AP==2){
                  erbu=erbu+jin;
                  erwei=erwei+jin;
              }
              document.getElementById(loca).innerHTML="<img src=人"+AP+"-左.jpg >";
       }
       else{           
             if(loca<8){
                    document.getElementById(loca).innerHTML="<img src=人"+AP+"-上.jpg >";
             }
             else if(loca>=8&&loca<25){
                    document.getElementById(loca).innerHTML="<img src=人"+AP+"-右.jpg >";
             }
             else if(loca>=25&&loca<32){
                    document.getElementById(loca).innerHTML="<img src=人"+AP+"-下.jpg >";
             }
             else if(loca>=32&&loca<=48){
                   document.getElementById(loca).innerHTML="<img src=人"+AP+"-左.jpg >";
             }
              else{
                    if(AP==1){
                        loca=loca-48;
                        yiwei=yiwei-48;
                        quanshu=quanshu+1;
                        if(quanshu>4){
                            alert("玩家一win");
                            document.getElementById(0).innerHTML="<img src=人1-上.jpg >";
                            document.getElementById(49).innerHTML="<img src=人2-上.jpg >";
                            document.getElementById(erwei).innerHTML="";
                            document.getElementById(loca).innerHTML="";
                            chongzhi()
                        }
                        else{
                            document.getElementById(loca).innerHTML="<img src=人1-上.jpg >";
                        }
                    }
                    else if(AP==2){
                        erwei=erwei-48;
                         loca=loca-48;
                        document.getElementById(erwei).innerHTML="<img src=人2-上.jpg >";
                    }    
             }
       }
          

       if(erbu>=yibu+17||yibu>=erbu+31){
             alert("玩家二win")  ;
             document.getElementById(0).innerHTML="<img src=人1-上.jpg >";
             document.getElementById(49).innerHTML="<img src=人2-上.jpg >";
             document.getElementById(erwei).innerHTML="";
             document.getElementById(loca).innerHTML="" ;
             chongzhi();
        }
          
         
       if(bing1==1&&bing2==1){
             alert("双方都处于冰冻状态！进入下一回合！");
             bing1=0;
             bing2=0;
             pd=0;
             if(AP==1){
                    AP=2;
             }
             else if(AP==2){
                    AP=1 ;
             }
       }
       
       else if(bing1==0&&bing2==1&&pd==1){
            alert("玩家二陷入冰冻状态无法自拔！")
             AP=1;
             bing2=2;
             pd=2;
       }
       else if(bing1==0&&bing2==2&&pd==2){
             alert("玩家二陷入冰冻状态无法自拔*2！");
             AP=1;
             bing2=0;
             pd=3;
       }
       else if(bing1==1&&bing2==0&&pd==1){
             alert("玩家一陷入冰冻状态无法自拔！")
             AP=2;
             bing1=2;
             pd=2;
       }
       else if(bing1==2&&bing2==0&&pd==2){
             alert("玩家一陷入冰冻状态无法自拔!*2");
             AP=2;
             bing1=0;
             pd=3;
       }
       else if(bing1==0&&bing2==0){
             if(AP==1){
                    AP=2;
             }
             else if(AP==2){
                    AP=1 ;
             }
       }

        if(pd==4){
            pd=0
        }
        else if(pd==3){
            pd=4
        }
        else if(pd==0){
            if(yiwei==7||yiwei==21||yiwei==43||yiwei==30){
                    bing1=1;
                    pd=1;
            }
              if(erwei==7||erwei==21||erwei==43||erwei==30){
                     bing2=1;
                     pd=1;
            }      
        }

}