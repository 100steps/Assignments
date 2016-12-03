    var MAX  = 37;
    var ran  = null;
    var ran1 = null;
    var green = {
        location : Number( localStorage.locationg ) || 1,
        sum      : Number( localStorage.sumg ) || 0,
        round    : Number( localStorage.roundg ) || 0
    }
    var red = {
        location : Number( localStorage.locationr ) || 19,
        sum      : Number( localStorage.sumr ) || 0,
        round    : Number( localStorage.roundr ) || 0
    }
    var t = localStorage.turn || 'g';
    var who = null;
    var i = 0;
    var mov = null;

    if ( t == 'g' ) {
        document.getElementById( 'not_box' ).innerHTML = '<p><b> &lt- 到绿方行动了</b></p>';
    }
    else {
        document.getElementById( 'not_box' ).innerHTML = '<p><b>到红方行动了 -&gt </b></p>';
    }
    document.getElementById( 'a' + green.location ).src = "green.jpg";
    document.getElementById( 'a' + red.location ).src = "red.jpg";

    function roll( s ){
        if ( s != t ) {
            if ( t == 'g' ) {
                alert( '到绿方行动了' );
                return;
            }
            else {
                alert( '到红方行动了' );
                return;
            }
        }
        if ( t == 'g' ) {
            document.getElementById( 'rollr' ).disabled = true;
            who = green;
        }
        else {
            document.getElementById( 'rollg' ).disabled = true;
            who = red;
        }

        var i = Math.floor( Math.random() * 6 + 1 );
        document.getElementById( 'pt' ).src = "zzz_" + i + ".jpg";

        ran1 = Math.floor( Math.random() * 15 + 1 );
        if ( ran1 == 5 ) {
            if ( who == green ) {
                alert( '绿方打出暴击。本回合点数翻倍' );
            }
            else {
                alert( '红方使用技能：福星高照。本回合点数翻倍' );
            }
            i = i * 2;
        }

        mov = setInterval( move , 100 , who , i );

        setTimeout( "check_win( who )", i * 100 + 1 );
        check( who , i );

        if ( t == 'g' ) {
            t = 'r';
            document.getElementById( 'rollr' ).disabled = false;
            document.getElementById( 'not_box' ).innerHTML = '<p><b>到红方行动了 -&gt </b></p>';
        } 
        else {
            t = 'g';
            document.getElementById( 'rollg' ).disabled = false;
            document.getElementById( 'not_box' ).innerHTML = '<p><b> &lt- 到绿方行动了</b></p>';
        }

        cache();
    }

    //后退            
    //tf用于判断是自己后退还是对方后退
    function dec( wh , n , tf ){
        clear( wh );
        wh.location -= n;
        wh.sum -= n;
        wh.round  = parseInt( wh.sum / ( MAX - 1 ) );
        if ( wh.location < 1 ) {
            wh.location += MAX
        }

        if ( wh == green) {
            document.getElementById( 'a' + wh.location ).src = "green.jpg";
            setTimeout( "check_win( red )" , 50 );
        }
        else {
            document.getElementById( 'a' + wh.location ).src = "red.jpg";
            setTimeout( "check_win( green )" , 50 );
        }

        if ( tf == true ) {
        	check( wh , 0 );
        }
        else {
        	if ( wh == green ) {
                who = green;
                t = 'g';
        		check( wh , 0 );
                return;
        	}
        	else {
                who = red;
                t = 'r';
        		check( wh , 0 );
                return;
        	}
        }
        
        return;
    }

    //前进
    function inc( who , n ){
        mov = setInterval( move , 100 , who , n );
        
        if ( who == green ) {
            document.getElementById( 'a' + who.location ).src = "green.jpg";
            setTimeout( "check_win( green )" , n * 100 + 1 );
        }
        else {
            document.getElementById( 'a' + who.location ).src = "red.jpg";
            setTimeout( "check_win( red )" , n * 100 + 1 );
        }

        check( who , n );
        return;
    }

    //检验是否获胜
    function check_win( who ){
        if ( who == green ) {
            if ( green.sum >= red.sum + 18 || green.round >= 5 ) {
                alert( '绿方赢了！请重新开始' );
                refresh();
                self.location = "攻占百步梯.html";
            }
        }
        else {
            if ( red.sum >= green.sum + 18 || red.round >= 5 ) {
                alert( '红方赢了！请重新开始' );
                refresh();
                self.location = "攻占百步梯.html";
            }
        }
    }

    //检验是否拾获+2道具
    function check_two( who ){
        if ( who.location == 6 ) {
            setTimeout( "inc( who , 2 )" , 50 );
        }
    }

    //检验是否拾获+3道具
    function check_three( who ){
        if ( who.location == 23 ) {
            setTimeout( "inc( who , 3 )" , 50 );
        }
    }

    //检验是否踩到炸弹
    function check_bomb( who ){
        if ( who.location == 10 || who.location == 32 ) {
            ran1 = Math.floor( Math.random() * 6 + 1 );
            if ( ran1 == 1 || ran1 == 3 ) {
                if ( who == green ) {
                    alert( '绿方使用技能：防爆专家。不受炸弹影响' );
                }
                else {
                    alert( '红方使用技能：凌波微步。避开了炸弹' );
                }
                return;
            }
            else {
                ran = Math.floor( Math.random() * 6 + 1 );
                setTimeout( "alert('你踩到炸弹啦！要退' + ran + '格!')" , 50);
                setTimeout( "dec( who , ran , true )" , 50);
            }
        }
    }

    //检验是否拾获未知道具
    function check_gift( who ){
        if ( who.location == 14 || who.location == 27 ) {
            ran1 = Math.floor( Math.random() * 10 + 1 );
            if ( ran1 == 1 || ran1 == 3 ) {
                alert( '恭喜你获得一次额外行动机会！' );
                if ( who == green) {
                    t = 'g';
                    document.getElementById( 'not_box' ).innerHTML = '<p><b> &lt- 到绿方行动了</b></p>';
                }
                else {
                    t = 'r';
                    document.getElementById( 'not_box' ).innerHTML = '<p><b>到红方行动了 -&gt </b></p>';
                }
            }
            else if ( ran1 == 2 || ran1 == 6 ) {
                ran = Math.floor( Math.random() * 6 + 1 );
                setTimeout( "alert('恭喜你，你的对手将往后退' + ran + '格!')" , 50);
                if ( who == green ) {
                    setTimeout( "dec( red , ran , false)" , 100);
                    return;
                }
                else {
                    setTimeout( "dec( green , ran , false)" , 100);
                    return;
                }
            }
            else if ( ran1 == 4 || ran1 == 5 ){
                ran = Math.floor( Math.random() * 6 + 1 );
                setTimeout( "alert('恭喜你，你将前进' + ran +' 格!')" , 50);
                setTimeout( "inc( who , ran )" , 100);
            }
            else {
            	setTimeout( "alert( '空空如也 > _ <')" , 50);
            	return;
            }
        }
    }

    //保存数据
    function cache(){
        localStorage.locationg = green.location;
        localStorage.sumg      = green.sum;
        localStorage.roundg    = green.round;
        localStorage.locationr = red.location;
        localStorage.sumr      = red.sum;
        localStorage.roundr    = red.round;
        localStorage.turn      = t;
    }

    //还原走过的路
    function clear( who ){
        if ( who.location == 6)  {
            document.getElementById( 'a' + who.location ).src = "plus2.jpg";
        }
        else if ( who.location == 23 ) {
            document.getElementById( 'a' + who.location ).src = "plus3.jpg";
        }
        else if ( who.location == 10 || who.location == 32 ) {
            document.getElementById( 'a' + who.location ).src = "bomb.jpg";
        }
        else if ( who.location == 14 || who.location == 27 ) {
            document.getElementById( 'a' + who.location ).src = "gift.jpg";
        }
        else if ( green.location == red.location ) {
            if ( who == green ) {
                document.getElementById( 'a' + who.location ).src = "red.jpg";
            }
            else {
                document.getElementById( 'a' + who.location ).src = "green.jpg";
            }
        }
        else { 
            document.getElementById( 'a' + who.location ).src = "cc.jpg";
        }
    }

    //~ 前移动画 ~
    var m = 0;
    function move( who , n ){
        document.getElementById( 'rollr' ).disabled = true;
        document.getElementById( 'rollg' ).disabled = true;
        if ( m >= n ) {
            m = 0;
            clearInterval( mov );
            document.getElementById( 'rollr' ).disabled = false;
            document.getElementById( 'rollg' ).disabled = false;
        }
        else {
            m ++;
            clear( who );
            who.location ++;
            who.sum ++;
            who.round = parseInt( who.sum / ( MAX - 1 ) );
            if ( who.location >= MAX ) {
                who.location -= MAX;
                who.location ++;
            }
            if ( who == green ) {
                document.getElementById( 'a' + green.location ).src = "green.jpg";
            }
            else {
                document.getElementById( 'a' + red.location ).src = "red.jpg";
            }
            cache();
        }
    }

    //刷新页面
    function refresh(){
        localStorage.locationg = 1;
        localStorage.sumg      = 0;
        localStorage.roundg    = 0;
        localStorage.locationr = 19;
        localStorage.sumr      = 0;
        localStorage.roundr    = 0;
        localStorage.turn      = 'g';
    }

    function check( who , n ){
        setTimeout( "check_bomb( who )" , n * 100 + 51 );
        setTimeout( "check_gift( who )" , n * 100 + 52 );
        setTimeout( "check_two( who )"  , n * 100 + 53 );
        setTimeout( "check_three( who )", n * 100 + 54 );
        cache();
    }