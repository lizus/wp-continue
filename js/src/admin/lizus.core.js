/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
Lizus核心库
Author: lizus.com
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function(g){
  //用于获取x的类型
  //getType :: a -> string
  var getType = function getType(x) {
      var type=Object.prototype.toString.call(x);
      return type.slice(8,-1);
  };
  //用于切换谓词函数的返回值
  //not :: () -> ( a -> boolean )
  var not = function not(fn) {
      return function () {
          return !fn.apply(null,[].slice.apply(arguments,[0]));
      }
  };
  //用于判断x是否存在
  // isExist :: a -> boolean
  var isExist=function isExist(x) {
    return x!=null;
  };

  //判断x是否为真，使用Boolean的结果
  // isTrue :: a -> boolean
  var isTrue =  Boolean;

  //判断x是否为空，此处判断空对象不算empty
  //isEmpty :: a -> boolean
  var isEmpty = function isEmpty(x) {
      if (isTrue(x) && Math.abs(Number(x)) != 0) return false;
      return true;
  };


  //生成返回自身的函数
  //of :: x -> () -> x
  var of=function (x) {
    return function () {
      return x;
    };
  };
  //用于生成只接受len个参数的fn
  //arity :: number -> () -> ()
  var arity = function arity(len,fn) {
    if (len<1) len=1;
    if (typeof fn != 'function') return null;
      return function () {
          var args=[].slice.apply(arguments,[0,len]);
          return fn.apply(null,args);
      }
  };
  //生成反转参数的函数
  //reverseArg :: () -> ()
  var reverseArg = function reverseArg(fn) {
    if (typeof fn != 'function') return null;
      return function () {
          var args=[].slice.apply(arguments,[0]).reverse();
          return fn.apply(null,args);
      }
  };
  //curry函数
  //curry :: () -> ()
  var curry=function curry(fn) {
    if (typeof fn != 'function') return null;
    return function curryMe() {
      var args=[].slice.apply(arguments,[0]);
      if (args.length >= fn.length) return fn.apply(null,args);
      return function () {
        return curryMe.apply(null,args.concat([].slice.apply(arguments,[0])));
      }
    }
  };
  //用于调试，tag用于标识调试信息，x为调试项，最终返回x不阻止程序运行
  //trace :: string -> a -> a
  var trace=curry(function trace(tag,x) {
    if (isExist(console)) {
      console.log(tag,x);
    }else{
      alert(tag);
      alert(opt);
    }
    return x;
  });
  //compose函数，用于组合函数，从右至左执行
  //compose :: () -> a
  var compose=function compose() {
    var args=[].slice.apply(arguments,[0]).reverse();
    return function () {
      var result=[].slice.apply(arguments,[0]);
      for (var i=0;i<args.length;i++) {
        if (typeof args[i] != 'function') return trace('the arguments is not a function',args[i]);
        result=args[i].apply(null,[].concat(result));
      }
      return result;
    }
  };
  //同compose，但是从左至右执行
  //flow:: () -> a
  var flow=reverseArg(compose);

  //用于判断两个参数是否相等
  //e :: a -> b -> boolean
  var e = curry(function e(a,b) {
      return a == b;
  });
  //用于判断b < a
  //lt :: a -> b -> boolean
  var lt = curry(function lt(a,b) {
      return b < a;
  });
  //用于判断b > a
  //gt :: a -> b -> boolean
  var gt = curry(function (a,b) {
      return b > a;
  });

  //用于判断x是否是a类型
  //isType :: a -> x -> boolean
  var isType = curry(function isType(a,x) {
      return e(a,getType(x));
  });
  //判断a是否是数组
  //isArray :: a -> boolean
  var isArray = isType('Array');

  //判断a是否是对象
  //isObject :: a -> boolean
  var isObject = isType('Object');

  //判断a是否是字符串
  //isString :: a -> boolean
  var isString = isType('String');

  //判断a是否是数字
  //isNumber :: a -> boolean
  var isNumber = isType('Number');

  //判断a是否是函数
  //isFunction :: a -> boolean
  var isFunction = isType('Function');

  //判断a是否是正则表达式
  //isRegExp :: a -> boolean
  var isRegExp = isType('RegExp');

  //判断a是否是布尔值
  //isBoolean :: a -> boolean
  var isBoolean = isType('Boolean');

  //判断a是否是日期对象
  //isDate :: a -> boolean
  var isDate = isType('Date');

  //curry化的Array重要函数，并将fn放在第一个参数位置上
  //map :: () -> array -> array
  var map = curry(function map(fn,col) {
      return Array.prototype.map.call(col,fn);
  });
  //filter :: () -> array -> array
  var filter = curry(function filter(fn,col) {
    return Array.prototype.filter.call(col,fn);
  });
  //reduce :: () -> array -> array
  var reduce = curry(function reduce(fn,col) {
    return Array.prototype.reduce.call(col,fn);
  });

  //深度复制，主要解决数组和对象的引用问题，通过深度复制去除引用
  //deepCopy :: a -> b
  var deepCopy=function (sth) {
    var re;
    if (isObject(sth)) {
      re={};
      for (var key in sth) {
        if (sth.hasOwnProperty(key)) {
          re[key]=deepCopy(sth[key]);
        }
      }
    }else if(isArray(sth)){
      re=map(deepCopy,sth);
    }else{
      re=sth;
    }
    return re;
  };

  //转变为数组
  //toArray :: a -> b
  var toArray = function (sth) {
    var re=[];
    if (isObject(sth)) {
      for (var key in sth) {
        if (sth.hasOwnProperty(key)) {
          if (isObject(sth[key])) {
            re.push([key,toArray(sth[key])]);
          }else{
            re.push([key,sth[key]]);
          }
        }
      }
    }else{
      re=re.concat(deepCopy(sth));
    }
    return re;
  };

  g.orz={
    trace:trace,
    arity:arity,
    reverseArg:reverseArg,
    curry:curry,
    compose:compose,
    flow:flow,
    not:not,
    of:of,
    e:e,
    lt:lt,
    gt:gt,
    getType:getType,
    isType:isType,
    isArray:isArray,
    isObject:isObject,
    isString:isString,
    isDate:isDate,
    isNumber:isNumber,
    isBoolean:isBoolean,
    isFunction:isFunction,
    isRegExp:isRegExp,
    isExist:isExist,
    isTrue:isTrue,
    isEmpty:isEmpty,
    map:map,
    filter:filter,
    reduce:reduce,
    deepCopy:deepCopy,
    toArray:toArray
  };
})(window);

/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
console在不同浏览器之间的兼容，需要输出时，统一使用orz.log
在IE下调试的时候，dir经常会出错，替换成log
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function(){
  if (!orz) return;

  orz.log=function () {
    var opt=Array.prototype.slice.call(arguments,0);
    if (window.console) {
      var fn;
      if(console.info){
        fn=window.console.info;
      }else{
        fn=window.console.log;
      }
      fn.apply(null,opt);
    }else{
      //alert(opt);
    }
  };
})();

/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
文本字符串处理相关函数
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
(function (){
    if (!orz)  return;

    //match的curry化，match的返回结果具有不确定性，要注意
    //match :: regexp || string -> string -> array
    orz.match=orz.curry(function (q,str) {
        if (orz.isEmpty(str)) return false;
        return String.prototype.match.call(str,q) || false;
    });

    //replace的curry化
    //replace :: regexp || string -> string || (string -> string) -> string -> string
    orz.replace=orz.curry(function (q,r,str) {
        if (orz.isEmpty(str)) return '';
        return String.prototype.replace.call(str,q,r);
    });

    //用于去掉字符串两端空白
    //trim :: string -> string
    orz.trim=orz.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,'');

    //用于字符串补位,第一个参数决定是否右补位（否则就是左补位），第二个参数为补位用的字符串，第三个是补位长度，第四个是应用字符串
    //如将3 补位为 03
    // pad :: boolean -> string -> number -> string -> string
    orz.pad=orz.curry(function (right,add,len,str) {
        right=orz.isTrue(right);
        if (orz.isEmpty(add)) add='0';
        add=String(add);
        str=String(str);
        var needLen=len-str.length;
        if (needLen <= 0) return str;
        var needStr='';
        while(needStr.length<needLen) {
            needStr+=add;
        }
        needStr=needStr.substring(0,needLen);
        return right ? str+needStr : needStr+str;
    });

    //左补位
    //lpad :: string -> number -> string -> string
    orz.lpad = orz.pad(false);

    //右补位
    //rpad :: string -> number -> string -> string
    orz.rpad = orz.pad(true);

    //将字符串解析为对象，用于一些设置或url的param项
    //strToObj :: string -> object
    orz.strToObj = function (str) {
        var obj={};
        if (orz.isString(str)) {
            str=str.split('&');
            var reg=new RegExp('([^=]+)=?([^=]*)','g');
            str.map(function (item) {
                var m;
                do {
                    m=reg.exec(item);
                    if (m) obj[m[1]]=decodeURIComponent(m[2]);
                } while (m);
            });
        }
        return obj;
    };
})();

(function (){
    if (!orz) return;

    //获取对象的属性值
    //prop :: object -> string -> a
    orz.prop = orz.curry(function (obj,prop) {
        if (orz.isObject(obj)) {
            return obj[prop] ? obj[prop] : orz.trace(prop + ' is not a prop in the object',obj[prop]);
        }
        return orz.trace('the first argument is not an object',null);
    });

    //获取对象的属性名数组
    //props :: object -> array
    orz.props = function (obj) {
        if (orz.isObject(obj)) return Object.keys(obj);
        return orz.trace('the argument is not an object',[]);
    };

    //用于设置项的object转换成string,例如url的params
    //objToStr :: object -> string
    orz.objToStr = function (obj) {
        var str='';
        if (orz.isObject(obj)) {
            str=[];
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    str.push(prop+'='+encodeURIComponent(orz.objToStr(obj[prop])));
                }
            }
            str=str.join('&');
        }
        if (orz.isString(obj)) str=obj;
        return str;
    };

    //拼接两个对象，当属性名相同时，使用obj的值，返回def
    //joinObject :: object -> object -> object
    orz.joinObject = function (def,obj) {
        var opt={};
        if (orz.isObject(def) && orz.isObject(obj)) {
            for(var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    def[prop] = obj[prop];
                }
            }
            opt=def;
        }
        return opt;
    };
})();
/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
date相关函数
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function(){
  if (!orz) return;

  //用于将参数格式化为日期对象
  //dateFormat :: a -> Date
  orz.dateFormat = function (a) {
    if (orz.isDate(a)) return a;
    if (orz.isString(a)) {
      var m=orz.match(/^[012]\d{3}[-\/][01]\d[-\/][0-3]\d(\s+[0-2]\d(:[0-5]\d(:[0-5]\d)?)?)?/gi,a);
      if (!orz.isEmpty(m)) return new Date(orz.replace(/\-/g,'/',m[0]));//ios不认时间格式：YYYY-MM-DD要改为YYYY/MM/DD
      return new Date(a);
    }
    if (orz.isNumber(a)) return new Date(a);
    return new Date('error');
  };

  //根据不同的f返回两个日期的时间差
  /* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
  //生成文章发布时间,传入的time为时间字符串
  orz.getDateDiff=function (time) {
    var second=orz.dateDiff('second',time,new Date());
    var day=Math.floor(second/(24*3600));
    var hour=Math.floor((second%(24*3600))/3600);
    var minute=Math.floor((second%3600)/60);
    var date=orz.dateFormat(time);
    var dateYear=date.getFullYear();
    var dateMonth=orz.lpad('0',2,date.getMonth()+1);
    var dateDate=orz.lpad('0',2,date.getDate());
    if (day>30) return dateYear+'-'+dateMonth+'-'+dateDate;
    if (day>3) return dateMonth+'-'+dateDate;
    if (day>0) return day+'天前';
    if (hour>0) return hour+'小时前';
    if (minute>0) return minute+'分钟前';
    if (second<0) return '预计于：'+dateYear+'-'+dateMonth+'-'+dateDate+'发表';
    return '刚刚发表';
  };
  ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
  //dateDiff :: string -> string -> string -> number || null
  orz.dateDiff=function (f,a,b) {
    a=orz.dateFormat(a).getTime();
    b=orz.dateFormat(b).getTime();
    if (isNaN(a) || isNaN(b)) return orz.trace('date is error. ',null);
    var diff=b-a;
    var div=1;
    switch (f) {
      case 'week':
        div=7*24*3600*1000;
        break;
      case 'day':
        div=24*3600*1000;
        break;
      case 'hour':
        div=3600*1000;
        break;
      case 'minute':
        div=60*1000;
        break;
      case 'second':
        div=1000;
        break;
      default:
        div=1;
    }
    return Math.floor(diff/div);
  };
})();

/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
json 处理
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
(function (){
    if (!orz)  return;

    orz.jsonEncode=function (str) {
        return JSON.stringify(str);
    };
    orz.jsonDecode=function (str) {
        var opt;
        try {
            opt=JSON.parse(str);
        } catch (e) {
            opt=null;
            orz.trace('decode json error: ',e);
        }
        return opt;
    };
})();
/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
设备判断
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
(function(){
	if (!orz)  return;

	//获取浏览器用户代理
	//getUserAgent :: () -> string
	var getUserAgent = function () {
		return navigator.userAgent;
	}

	//判断内容非空
	//isNotEmpty :: a -> boolean
	var isNotEmpty = orz.not(orz.isEmpty);

	//返回浏览器标识名称
	//getDevice :: () -> string
	orz.getDevice=function () {
		var u=getUserAgent();
		if (u.indexOf('micromessenger')!=-1) return '微信';
		if (u.indexOf('Android')!=-1) return 'Android';
		if (u.indexOf('iPad')!=-1) return 'iPad';
		if (u.indexOf('iPhone')!=-1) {
			if (screen.height==812) return 'iPhone X';
			return 'iPhone';
		}
		if (u.indexOf('Edge')!=-1) return 'Edge浏览器';
		if (u.indexOf('360SE')!=-1) return '360浏览器';
		if (u.indexOf('360EE')!=-1) return '360浏览器';
		if (u.indexOf('Maxthon')!=-1) return '傲游浏览器';
		if (u.indexOf('Tencent')!=-1) return 'QQ浏览器';
		if (u.indexOf('MetaSr')!=-1) return '搜狗浏览器';
		if (u.indexOf('Opera')!=-1) return 'Opera浏览器';
		if (u.indexOf('Firefox')!=-1) return 'Firefox浏览器';
		if (u.indexOf('Chrome')!=-1) return 'Chrome浏览器';
		if (u.indexOf('Safari')!=-1) return 'Safari浏览器';
		if (u.indexOf('MSIE')!=-1) return 'IE浏览器';
		if (u.indexOf('like Gecko')!=-1) {
			if (u.indexOf('OPR')!=-1) {
				return 'Opara浏览器';
			}
			return 'IE浏览器';
		}
	}
	/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
	用于获取浏览器设置
	常用属性有：
	clientWidth - 浏览器视口宽
	clientHeight - 浏览器视口高
	使用时创建示例如下：
	var clientWidthBigThen=function(w){
		var gte=orz.not(orz.lt(w));
		return orz.flow(orz.getDocument('clientWidth'),gte);
    };
	var lg=clientWidthBigThen(1200);
	var md=clientWidthBigThen(992);
	var sm=clientWidthBigThen(768);
	//getDocument :: string -> string
	---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
	orz.getDocument=function (prop) {
		return function () {
			return document.documentElement[prop] || document.body[prop] || 0;
		};
	};

	//判断设备是否是ios
	//isIos :: () -> boolean
	orz.isIos=orz.flow(getUserAgent,orz.match(/(iPhone|iPod|ios|iPad)/i),isNotEmpty);

	//判断设备是否是安卓
	//isAndroid :: () -> boolean
	orz.isAndroid=orz.flow(getUserAgent,orz.match(/Android/i),isNotEmpty);

	//判断设备是否是移动端
	//isMobile :: () -> boolean
	orz.isMobile=orz.flow(getUserAgent,orz.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i),isNotEmpty);

	//判断设备是否是PC端
	//isPC :: () -> boolean
	orz.isPC=orz.not(orz.isMobile);

})();

(function(){
  if (!orz)  return;

  /* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
  使用帧动画优化动画表现
  传入fn来实现每一帧的动画内容
  使用start开始动画，stop停止
  var n=0;
  var a=orz.animate(function (){
      orz.trace('n: ',n++);
  });
  a.start();
  ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
  //animate :: () -> object
  orz.animate=function (fn) {
    var id=0,//记录动画的ID
        startTime=0,//记录动画开始的时间
        stopTime=0,//记录动画停止的时间
        hasStart=false;//是否开始动画了
    function animation(){
      fn.call(this);
      id = requestAnimationFrame(animation);
    };
    return {
      startTime:startTime,
      stopTime:stopTime,
      start:function (){
        if (hasStart) return;
        startTime=new Date();
        id = requestAnimationFrame(animation);
        hasStart=true;
      },
      stop:function () {
        stopTime=new Date();
        if (id) {
          cancelAnimationFrame(id);
        }
        id=0;
        hasStart=false;
      }
    };
  };
})();

(function(){
    if (!orz) return;

    //用于获取地址中的GET参数值，传入url: location.search可获得当前页的参数
    // urlGet :: string -> string -> string
    orz.urlGet = orz.curry(function $_GET(url,tag) {
        if (url) {
            var reg=new RegExp('[\?&]'+tag+'=([^&]*)','g');
            var m,n;
            //此处利用循环获取最后一个tag的值，预防url中存在多个同名tag
            do {
                m=reg.exec(url);
                if (m) n=m;
            } while (m);
            if (orz.isArray(n)) {
                return n[1];
            }
        }
        return '';
    });

    //获取url中所有参数
    //urlGets :: string -> object
    orz.urlGets = function (url) {
        var obj={};
        if (url) {
            var reg=new RegExp('[\?&]([^=&]+)=?([^&]*)','g');
            var m;
            do {
                m=reg.exec(url);
                if (m) obj[m[1]]=m[2];
            } while (m);
        }
        return obj;
    };

    //获取地址中的锚名称
    //urlAnchor :: string -> string
    orz.urlAnchor = function (url) {
        if (url) {
            var reg = new RegExp('#([^\?&]*)');
            var m = reg.exec(url);
            if (orz.isArray(m)) return m[1];
        }
        return '';
    };

    //用于获取url的基础地址
    //urlBase :: string -> string
    orz.urlBase =  function (url) {
        if (orz.isString(url)) {
            url=orz.replace(/#.*/,'',url);
            url=orz.replace(/\?.*/,'',url);
            return url;
        }
        return orz.trace('url is not a string','');
    };

    //根据传参生成新的地址，传参可以是字符串，也可以是对象
    //getUrl :: string -> string || object -> string
    orz.getUrl = function (url,params) {
        if (orz.isString(url)) {
            var defParams=orz.urlGets(url);
            var baseUrl=orz.urlBase(url);
            if (orz.isString(params)) params=orz.strToObj(params);
            if (orz.isObject(params)) defParams=orz.joinObject(defParams,params);
            if (Object.keys(defParams).length>0) {
                url=baseUrl+'?'+orz.objToStr(defParams);
            }
        }
        return url;
    };
})();

/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
cookie相关函数
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
(function (){
    if (!orz)  return;

    //获取cookie
    orz.getCookie=function (name) {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg)){
            return decodeURIComponent(arr[2]);
        }
        return '';
    };
    //设置cookie
    orz.setCookie=function (cname,cvalue,exdays,currentPath) {
        if (!orz.isExist(exdays)) exdays=1;
        exdays=exdays-0;
        if(isNaN(exdays)) exdays=1;
        if (!orz.isExist(currentPath)) {
            path=';path=/';
        }else{
            path='';
        }
        var d=new Date();
        d.setTime(d.getTime()+(exdays*24*60*60*1000));
        var expires="expires="+d.toUTCString();
        document.cookie=cname+"="+encodeURIComponent(cvalue)+"; "+expires+path;
    };
    //清除cookie
    orz.delCookie=function (name) {
        setCookie(name, "", -1);
    };
})();
