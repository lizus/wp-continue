(function (){
    //为ie9以下浏览器添加Object.create方法
    if (typeof Object.create !== "function") {
        Object.create = function (proto, propertiesObject) {
            if (typeof proto !== 'object' && typeof proto !== 'function') {
                throw new TypeError('Object prototype may only be an Object: ' + proto);
            } else if (proto === null) {
                throw new Error("This browser's implementation of Object.create is a shim and doesn't support 'null' as the first argument.");
            }
            if (typeof propertiesObject != 'undefined') throw new Error("This browser's implementation of Object.create is a shim and doesn't support a second argument.");
            function F() {}
            F.prototype = proto;
            return new F();
        };
    }
    // Production steps of ECMA-262, Edition 5, 15.4.4.18
    // Reference: http://es5.github.io/#x15.4.4.18
    if (!Array.prototype.forEach) {

        Array.prototype.forEach = function(callback, thisArg) {

            var T, k;

            if (this == null) {
                throw new TypeError(' this is null or not defined');
            }

            // 1. Let O be the result of calling toObject() passing the
            // |this| value as the argument.
            var O = Object(this);

            // 2. Let lenValue be the result of calling the Get() internal
            // method of O with the argument "length".
            // 3. Let len be toUint32(lenValue).
            var len = O.length >>> 0;

            // 4. If isCallable(callback) is false, throw a TypeError exception.
            // See: http://es5.github.com/#x9.11
            if (typeof callback !== "function") {
                throw new TypeError(callback + ' is not a function');
            }

            // 5. If thisArg was supplied, let T be thisArg; else let
            // T be undefined.
            if (arguments.length > 1) {
                T = thisArg;
            }

            // 6. Let k be 0
            k = 0;

            // 7. Repeat, while k < len
            while (k < len) {

                var kValue;

                // a. Let Pk be ToString(k).
                //    This is implicit for LHS operands of the in operator
                // b. Let kPresent be the result of calling the HasProperty
                //    internal method of O with argument Pk.
                //    This step can be combined with c
                // c. If kPresent is true, then
                if (k in O) {

                    // i. Let kValue be the result of calling the Get internal
                    // method of O with argument Pk.
                    kValue = O[k];

                    // ii. Call the Call internal method of callback with T as
                    // the this value and argument list containing kValue, k, and O.
                    callback.call(T, kValue, k, O);
                }
                // d. Increase k by 1.
                k++;
            }
            // 8. return undefined
        };
    }
    // 实现 ECMA-262, Edition 5, 15.4.4.19
    // 参考: http://es5.github.com/#x15.4.4.19
    if (!Array.prototype.map) {
        Array.prototype.map = function(callback, thisArg) {

            var T, A, k;

            if (this == null) {
                throw new TypeError(" this is null or not defined");
            }

            // 1. 将O赋值为调用map方法的数组.
            var O = Object(this);

            // 2.将len赋值为数组O的长度.
            var len = O.length >>> 0;

            // 3.如果callback不是函数,则抛出TypeError异常.
            if (Object.prototype.toString.call(callback) != "[object Function]") {
                throw new TypeError(callback + " is not a function");
            }

            // 4. 如果参数thisArg有值,则将T赋值为thisArg;否则T为undefined.
            if (thisArg) {
                T = thisArg;
            }

            // 5. 创建新数组A,长度为原数组O长度len
            A = new Array(len);

            // 6. 将k赋值为0
            k = 0;

            // 7. 当 k < len 时,执行循环.
            while(k < len) {

                var kValue, mappedValue;

                //遍历O,k为原数组索引
                if (k in O) {

                    //kValue为索引k对应的值.
                    kValue = O[ k ];

                    // 执行callback,this指向T,参数有三个.分别是kValue:值,k:索引,O:原数组.
                    mappedValue = callback.call(T, kValue, k, O);

                    // 返回值添加到新数组A中.
                    A[ k ] = mappedValue;
                }
                // k自增1
                k++;
            }

            // 8. 返回新数组A
            return A;
        };
    }
    if (!Array.prototype.filter){
        Array.prototype.filter = function(func, thisArg) {
            'use strict';
            if ( ! ((typeof func === 'Function' || typeof func === 'function') && this) )
                throw new TypeError();

            var len = this.length >>> 0,
                res = new Array(len), // preallocate array
                t = this, c = 0, i = -1;
            if (thisArg === undefined){
                while (++i !== len){
                    // checks to see if the key was set
                    if (i in this){
                        if (func(t[i], i, t)){
                            res[c++] = t[i];
                        }
                    }
                }
            }
            else{
                while (++i !== len){
                    // checks to see if the key was set
                    if (i in this){
                        if (func.call(thisArg, t[i], i, t)){
                            res[c++] = t[i];
                        }
                    }
                }
            }

            res.length = c; // shrink down array to proper size
            return res;
        };
    }
    Array.prototype.reduce = Array.prototype.reduce || function(callback, opt_initialValue){
        if (null === this || 'undefined' === typeof this) {
            // At the moment all modern browsers, that support strict mode, have
            // native implementation of Array.prototype.reduce. For instance, IE8
            // does not support strict mode, so this check is actually useless.
            throw new TypeError(
                'Array.prototype.reduce called on null or undefined');
        }
        if ('function' !== typeof callback) {
            throw new TypeError(callback + ' is not a function');
        }
        var index, value,
            length = this.length >>> 0,
            isValueSet = false;
        if (1 < arguments.length) {
            value = opt_initialValue;
            isValueSet = true;
        }
        for (index = 0; length > index; ++index) {
            if (this.hasOwnProperty(index)) {
                if (isValueSet) {
                    value = callback(value, this[index], index, this);
                }
                else {
                    value = this[index];
                    isValueSet = true;
                }
            }
        }
        if (!isValueSet) {
            throw new TypeError('Reduce of empty array with no initial value');
        }
        return value;
    };
    if (!Object.keys) {
        Object.keys = (function () {
            var hasOwnProperty = Object.prototype.hasOwnProperty,
                hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
                dontEnums = [
                    'toString',
                    'toLocaleString',
                    'valueOf',
                    'hasOwnProperty',
                    'isPrototypeOf',
                    'propertyIsEnumerable',
                    'constructor'
                ],
                dontEnumsLength = dontEnums.length;

            return function (obj) {
                if (typeof obj !== 'object' && typeof obj !== 'function' || obj === null) throw new TypeError('Object.keys called on non-object');

                var result = [];

                for (var prop in obj) {
                    if (hasOwnProperty.call(obj, prop)) result.push(prop);
                }

                if (hasDontEnumBug) {
                    for (var i=0; i < dontEnumsLength; i++) {
                        if (hasOwnProperty.call(obj, dontEnums[i])) result.push(dontEnums[i]);
                    }
                }
                return result;
            }
        })()
    };
})();