var i=1
var pastposition1=0
var pastposition2=18
var allstep1=0
var allstep2=0
function go(){ 
    if(i>=1){ 
        var past1= document.getElementById("r"+pastposition1);
        past1.style.backgroundColor="green";
        var step1=Math.ceil( (Math.random())*6 );
        var position1=step1+pastposition1;
        document.getElementById("text1").innerHTML="�����ĵ���Ϊ"+step1   
        if(position1>35){
            position1=position1-35
        };
        var nextposition1=document.getElementById("r"+position1);
        nextposition1.style.backgroundColor="blue";
        if(position1==10){
            alert("�н�˳����ǰ�����")
            position1=position1+5;
            allstep1=allstep1+5;
            nextposition1.style.backgroundColor="green";
            var nextposition1=document.getElementById("r"+position1);
            nextposition1.style.backgroundColor="blue";
        }
        pastposition1=position1
        i=i-1
        allstep1=allstep1+step1
        if(position1==25){
        alert("������Ϯ��ԭ������һ�غ�")
        i=i-1 
        }                          
        if(position1==2){
            alert("��ò������ٴ�ǰ��һ�غ�")
            i=i+1
        }
    }        
    else{
        var past2= document.getElementById("r"+pastposition2)
        past2.style.backgroundColor="green"
        var step2=Math.ceil( (Math.random())*6 );
        var position2=step2+pastposition2;
        document.getElementById("text2").innerHTML="�����ĵ���Ϊ"+step2
        if(position2>35){
        position2=position2-35
        }
        var nextposition2=document.getElementById("r"+position2);
        nextposition2.style.backgroundColor="red";
        if(position2==10){
            alert("�н�˳����ǰ�����")
            position2=position2+5
            allstep2=allstep2+5
            nextposition2.style.backgroundColor="green"
            var nextposition2=document.getElementById("r"+position2)
            nextposition2.style.backgroundColor="red"
        }
        pastposition2=position2
        i=i+1
        allstep2=allstep2+step2
        if(position2==25){
        alert("������Ϯ��ԭ������һ�غ�")
        i=i+1}
        if(position2==2){
            alert("��ò������ٴ�ǰ��һ�غ�")
            i=i-1
        }
    }
    var j=allstep1-allstep2
    var all1=allstep1
    var all2=allstep2
    if(j>=18){
        alert("������ʤ")
        end()      
    }
    if(j<=-18){
        alert("�췽��ʤ")
        end()       
    }
    if(all1>=180){
        alert("������Ȧ��������ʤ")
        end() 
    }      
    if(all2>=180){
        alert("������Ȧ���췽��ʤ")
        end()       
    }
    function end(){
        var nextposition1=document.getElementById("r"+pastposition1)
        var nextposition2=document.getElementById("r"+pastposition2)
        nextposition2.style.backgroundColor="#008000"
        nextposition1.style.backgroundColor="#008000"
        i=1
        pastposition1=0
        pastposition2=18
        allstep1=0
        allstep2=0
        var start1=document.getElementById("r0")
        var start2=document.getElementById("r18")
        start1.style.backgroundColor="blue"
        start2.style.backgroundColor="red"
        document.getElementById("text1").innerHTML=""
        document.getElementById("text2").innerHTML=""
    }
}
