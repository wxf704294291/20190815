webpackJsonp([2],{125:function(e,t,r){r(148);var o=r(49).Object;e.exports=function(e,t,r){return o.defineProperty(e,t,r)}},148:function(e,t,r){var o=r(61);o(o.S+o.F*!r(50),"Object",{defineProperty:r(53).f})},156:function(e,t,r){e.exports={default:r(125),__esModule:!0}},158:function(e,t,r){"use strict";t.__esModule=!0;var o=r(156),n=function(e){return e&&e.__esModule?e:{default:e}}(o);t.default=function(e,t,r){return t in e?(0,n.default)(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}},169:function(e,t,r){t=e.exports=r(13)(),t.push([e.i,'body[data-v-4fb9697c]{background:#fff}header[data-v-4fb9697c]{display:box!important;display:-webkit-box!important;padding:1rem .8rem;background:#fff;margin-bottom:1px}header .input[data-v-4fb9697c]{width:100%;height:3.2rem;line-height:3.2rem;background:#fff;color:#777;font-size:1.3rem;border-radius:4px;position:relative;padding-left:.8rem;padding-right:.8rem;border:1px solid #eee;box-sizing:content-box;box-flex:1;-ms-flex:1!important;flex:1!important;-webkit-box-flex:1!important}header .input span[data-v-4fb9697c]{position:absolute;font-size:1.4rem;left:.8rem;height:3.2rem;line-height:3.2rem}header .input span[data-v-4fb9697c]:after{position:absolute;right:-1rem;top:50%;margin-top:-.2rem;content:"";display:block;width:0;height:0;border-left:.4rem solid transparent;border-right:.4rem solid transparent;border-top:.5rem solid #999}header .input a[data-v-4fb9697c]{position:absolute;top:0;right:0;bottom:0;left:0}header .input input[data-v-4fb9697c]{font-size:1.3rem;height:1.8rem;line-height:1.8rem;width:100%;color:#333;border:none}header .icon-jiantou12[data-v-4fb9697c]{font-size:1.8rem;margin-right:.6rem;height:3.2rem;line-height:3.2rem;color:#888}header button[data-v-4fb9697c]{margin-left:.6rem;background:#eee;color:#555;height:3.2rem;line-height:3.2rem;padding:0 1rem;border-radius:4px;font-size:1.3rem;color:#333;border:1px solid #eee;box-sizing:content-box}.search__list[data-v-4fb9697c]{background:#fff;padding-top:1rem;position:absolute;width:100%;top:5.3rem;bottom:0;border-top:1px solid #eee;overflow-y:auto}.search__list h5[data-v-4fb9697c]{padding:.5rem .9rem;font-size:1.3rem;font-weight:400;color:#666;display:-ms-flexbox;display:flex;display:-webkit-flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between}.search__list section[data-v-4fb9697c]{overflow:hidden;padding:.9rem;padding-top:0}.search__list--hot ul li[data-v-4fb9697c]{float:left;padding:.4rem}.search__list--hot ul li a[data-v-4fb9697c]{display:block;width:100%;text-align:center;font-size:1.2rem;color:#333;padding:.6rem 1.3rem;border-radius:4px;border:1px solid #eee;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.search__list--history ul li[data-v-4fb9697c]{border-bottom:1px solid #eee;font-size:1.2rem}.search__list--history ul li a[data-v-4fb9697c]{display:block;padding:1.3rem 0;color:#333}.search__list--history ul li[data-v-4fb9697c]:last-of-type{border-bottom:none}',""])},174:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"search"},[r("header",[r("div",{staticClass:"input"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.keyWord,expression:"keyWord"}],attrs:{type:"text",placeholder:"商品搜索"},domProps:{value:e.keyWord},on:{input:function(t){t.target.composing||(e.keyWord=t.target.value)}}})]),e._v(" "),r("button",{on:{click:function(t){e.search()}}},[e._v("搜索")])]),e._v(" "),r("div",{staticClass:"search__list"},[r("div",{staticClass:"search__list--hot"},[r("h5",[e._v("热门搜索")]),e._v(" "),r("section",[r("ul",e._l(e.hotKeywords,function(t,o){return r("router-link",{key:o,attrs:{to:{path:"/category",query:{keyword:t}},tag:"li"}},[r("a",{on:{click:function(r){e.search(t)}}},[e._v("\n                            "+e._s(t)+"\n                        ")])])}))])]),e._v(" "),r("div",{staticClass:"search__list--history"},[r("h5",[e._v("搜索历史"),r("i",{staticClass:"iconfont icon-clear",on:{click:e.clearHistory}})]),e._v(" "),r("section",[r("ul",e._l(e.history,function(t,o){return r("li",{key:o},[r("a",{on:{click:function(r){e.search(t)}}},[e._v(e._s(t))])])}))])])])])},staticRenderFns:[]}},182:function(e,t,r){var o=r(169);"string"==typeof o&&(o=[[e.i,o,""]]),o.locals&&(e.exports=o.locals);r(15)("d126930e",o,!0)},189:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o,n=r(158),i=r.n(n),a=r(56);r.n(a);t.default=(o={name:"search",data:function(){return{type:"商品",history:[],hotKeywords:[],keyWord:""}},created:function(){},methods:{},activated:function(){this.init()}},i()(o,"methods",{init:function(){var e=this;this.$http.post(this.url("search&c=index&a=hotkey")).then(function(t){var r=t.data.hotkey,o=r.history,n=r.hot_keywords;e.history=o||[],n&&(e.hotKeywords=n)})},toggleType:function(){"商品"==this.type?this.type="店铺":this.type="商品"},clearHistory:function(){var e=this;this.$http.post(this.url("category&a=clear_history")).then(function(t){0==t.data.status&&(e.history=[])})},search:function(){this.$router.push({name:"category",query:{keyword:this.keyWord}})}}),i()(o,"computed",{categorySearch:function(){return"index.php?m=category&a=search&keyword="}}),o)},46:function(e,t,r){function o(e){r(182)}var n=r(14)(r(189),r(174),o,"data-v-4fb9697c",null);e.exports=n.exports},47:function(e,t){var r=e.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=r)},49:function(e,t){var r=e.exports={version:"2.4.0"};"number"==typeof __e&&(__e=r)},50:function(e,t,r){e.exports=!r(64)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},51:function(e,t,r){var o=r(54);e.exports=function(e){if(!o(e))throw TypeError(e+" is not an object!");return e}},52:function(e,t,r){var o=r(53),n=r(65);e.exports=r(50)?function(e,t,r){return o.f(e,t,n(1,r))}:function(e,t,r){return e[t]=r,e}},53:function(e,t,r){var o=r(51),n=r(83),i=r(88),a=Object.defineProperty;t.f=r(50)?Object.defineProperty:function(e,t,r){if(o(e),t=i(t,!0),o(r),n)try{return a(e,t,r)}catch(e){}if("get"in r||"set"in r)throw TypeError("Accessors not supported!");return"value"in r&&(e[t]=r.value),e}},54:function(e,t){e.exports=function(e){return"object"==typeof e?null!==e:"function"==typeof e}},55:function(e,t,r){var o=r(58);e.exports=function(e,t,r){if(o(e),void 0===t)return e;switch(r){case 1:return function(r){return e.call(t,r)};case 2:return function(r,o){return e.call(t,r,o)};case 3:return function(r,o,n){return e.call(t,r,o,n)}}return function(){return e.apply(t,arguments)}}},56:function(e,t,r){"use strict";var o=r(93),n=r(92),i=r(66);e.exports={formats:i,parse:n,stringify:o}},58:function(e,t){e.exports=function(e){if("function"!=typeof e)throw TypeError(e+" is not a function!");return e}},60:function(e,t,r){var o=r(54),n=r(47).document,i=o(n)&&o(n.createElement);e.exports=function(e){return i?n.createElement(e):{}}},61:function(e,t,r){var o=r(47),n=r(49),i=r(55),a=r(52),c=function(e,t,r){var l,s,u,f=e&c.F,p=e&c.G,d=e&c.S,y=e&c.P,h=e&c.B,b=e&c.W,m=p?n:n[t]||(n[t]={}),v=m.prototype,g=p?o:d?o[t]:(o[t]||{}).prototype;p&&(r=t);for(l in r)(s=!f&&g&&void 0!==g[l])&&l in m||(u=s?g[l]:r[l],m[l]=p&&"function"!=typeof g[l]?r[l]:h&&s?i(u,o):b&&g[l]==u?function(e){var t=function(t,r,o){if(this instanceof e){switch(arguments.length){case 0:return new e;case 1:return new e(t);case 2:return new e(t,r)}return new e(t,r,o)}return e.apply(this,arguments)};return t.prototype=e.prototype,t}(u):y&&"function"==typeof u?i(Function.call,u):u,y&&((m.virtual||(m.virtual={}))[l]=u,e&c.R&&v&&!v[l]&&a(v,l,u)))};c.F=1,c.G=2,c.S=4,c.P=8,c.B=16,c.W=32,c.U=64,c.R=128,e.exports=c},64:function(e,t){e.exports=function(e){try{return!!e()}catch(e){return!0}}},65:function(e,t){e.exports=function(e,t){return{enumerable:!(1&e),configurable:!(2&e),writable:!(4&e),value:t}}},66:function(e,t,r){"use strict";var o=String.prototype.replace,n=/%20/g;e.exports={default:"RFC3986",formatters:{RFC1738:function(e){return o.call(e,n,"+")},RFC3986:function(e){return e}},RFC1738:"RFC1738",RFC3986:"RFC3986"}},67:function(e,t,r){"use strict";var o=Object.prototype.hasOwnProperty,n=function(){for(var e=[],t=0;t<256;++t)e.push("%"+((t<16?"0":"")+t.toString(16)).toUpperCase());return e}();t.arrayToObject=function(e,t){for(var r=t&&t.plainObjects?Object.create(null):{},o=0;o<e.length;++o)void 0!==e[o]&&(r[o]=e[o]);return r},t.merge=function(e,r,n){if(!r)return e;if("object"!=typeof r){if(Array.isArray(e))e.push(r);else{if("object"!=typeof e)return[e,r];(n.plainObjects||n.allowPrototypes||!o.call(Object.prototype,r))&&(e[r]=!0)}return e}if("object"!=typeof e)return[e].concat(r);var i=e;return Array.isArray(e)&&!Array.isArray(r)&&(i=t.arrayToObject(e,n)),Array.isArray(e)&&Array.isArray(r)?(r.forEach(function(r,i){o.call(e,i)?e[i]&&"object"==typeof e[i]?e[i]=t.merge(e[i],r,n):e.push(r):e[i]=r}),e):Object.keys(r).reduce(function(e,o){var i=r[o];return Object.prototype.hasOwnProperty.call(e,o)?e[o]=t.merge(e[o],i,n):e[o]=i,e},i)},t.decode=function(e){try{return decodeURIComponent(e.replace(/\+/g," "))}catch(t){return e}},t.encode=function(e){if(0===e.length)return e;for(var t="string"==typeof e?e:String(e),r="",o=0;o<t.length;++o){var i=t.charCodeAt(o);45===i||46===i||95===i||126===i||i>=48&&i<=57||i>=65&&i<=90||i>=97&&i<=122?r+=t.charAt(o):i<128?r+=n[i]:i<2048?r+=n[192|i>>6]+n[128|63&i]:i<55296||i>=57344?r+=n[224|i>>12]+n[128|i>>6&63]+n[128|63&i]:(o+=1,i=65536+((1023&i)<<10|1023&t.charCodeAt(o)),r+=n[240|i>>18]+n[128|i>>12&63]+n[128|i>>6&63]+n[128|63&i])}return r},t.compact=function(e,r){if("object"!=typeof e||null===e)return e;var o=r||[],n=o.indexOf(e);if(-1!==n)return o[n];if(o.push(e),Array.isArray(e)){for(var i=[],a=0;a<e.length;++a)e[a]&&"object"==typeof e[a]?i.push(t.compact(e[a],o)):void 0!==e[a]&&i.push(e[a]);return i}return Object.keys(e).forEach(function(r){e[r]=t.compact(e[r],o)}),e},t.isRegExp=function(e){return"[object RegExp]"===Object.prototype.toString.call(e)},t.isBuffer=function(e){return null!==e&&void 0!==e&&!!(e.constructor&&e.constructor.isBuffer&&e.constructor.isBuffer(e))}},83:function(e,t,r){e.exports=!r(50)&&!r(64)(function(){return 7!=Object.defineProperty(r(60)("div"),"a",{get:function(){return 7}}).a})},88:function(e,t,r){var o=r(54);e.exports=function(e,t){if(!o(e))return e;var r,n;if(t&&"function"==typeof(r=e.toString)&&!o(n=r.call(e)))return n;if("function"==typeof(r=e.valueOf)&&!o(n=r.call(e)))return n;if(!t&&"function"==typeof(r=e.toString)&&!o(n=r.call(e)))return n;throw TypeError("Can't convert object to primitive value")}},92:function(e,t,r){"use strict";var o=r(67),n=Object.prototype.hasOwnProperty,i={allowDots:!1,allowPrototypes:!1,arrayLimit:20,decoder:o.decode,delimiter:"&",depth:5,parameterLimit:1e3,plainObjects:!1,strictNullHandling:!1},a=function(e,t){for(var r={},o=e.split(t.delimiter,t.parameterLimit===1/0?void 0:t.parameterLimit),i=0;i<o.length;++i){var a,c,l=o[i],s=-1===l.indexOf("]=")?l.indexOf("="):l.indexOf("]=")+1;-1===s?(a=t.decoder(l),c=t.strictNullHandling?null:""):(a=t.decoder(l.slice(0,s)),c=t.decoder(l.slice(s+1))),n.call(r,a)?r[a]=[].concat(r[a]).concat(c):r[a]=c}return r},c=function(e,t,r){if(!e.length)return t;var o,n=e.shift();if("[]"===n)o=[],o=o.concat(c(e,t,r));else{o=r.plainObjects?Object.create(null):{};var i="["===n.charAt(0)&&"]"===n.charAt(n.length-1)?n.slice(1,-1):n,a=parseInt(i,10);!isNaN(a)&&n!==i&&String(a)===i&&a>=0&&r.parseArrays&&a<=r.arrayLimit?(o=[],o[a]=c(e,t,r)):o[i]=c(e,t,r)}return o},l=function(e,t,r){if(e){var o=r.allowDots?e.replace(/\.([^.[]+)/g,"[$1]"):e,i=/(\[[^[\]]*])/,a=/(\[[^[\]]*])/g,l=i.exec(o),s=l?o.slice(0,l.index):o,u=[];if(s){if(!r.plainObjects&&n.call(Object.prototype,s)&&!r.allowPrototypes)return;u.push(s)}for(var f=0;null!==(l=a.exec(o))&&f<r.depth;){if(f+=1,!r.plainObjects&&n.call(Object.prototype,l[1].slice(1,-1))&&!r.allowPrototypes)return;u.push(l[1])}return l&&u.push("["+o.slice(l.index)+"]"),c(u,t,r)}};e.exports=function(e,t){var r=t||{};if(null!==r.decoder&&void 0!==r.decoder&&"function"!=typeof r.decoder)throw new TypeError("Decoder has to be a function.");if(r.delimiter="string"==typeof r.delimiter||o.isRegExp(r.delimiter)?r.delimiter:i.delimiter,r.depth="number"==typeof r.depth?r.depth:i.depth,r.arrayLimit="number"==typeof r.arrayLimit?r.arrayLimit:i.arrayLimit,r.parseArrays=!1!==r.parseArrays,r.decoder="function"==typeof r.decoder?r.decoder:i.decoder,r.allowDots="boolean"==typeof r.allowDots?r.allowDots:i.allowDots,r.plainObjects="boolean"==typeof r.plainObjects?r.plainObjects:i.plainObjects,r.allowPrototypes="boolean"==typeof r.allowPrototypes?r.allowPrototypes:i.allowPrototypes,r.parameterLimit="number"==typeof r.parameterLimit?r.parameterLimit:i.parameterLimit,r.strictNullHandling="boolean"==typeof r.strictNullHandling?r.strictNullHandling:i.strictNullHandling,""===e||null===e||void 0===e)return r.plainObjects?Object.create(null):{};for(var n="string"==typeof e?a(e,r):e,c=r.plainObjects?Object.create(null):{},s=Object.keys(n),u=0;u<s.length;++u){var f=s[u],p=l(f,n[f],r);c=o.merge(c,p,r)}return o.compact(c)}},93:function(e,t,r){"use strict";var o=r(67),n=r(66),i={brackets:function(e){return e+"[]"},indices:function(e,t){return e+"["+t+"]"},repeat:function(e){return e}},a=Date.prototype.toISOString,c={delimiter:"&",encode:!0,encoder:o.encode,encodeValuesOnly:!1,serializeDate:function(e){return a.call(e)},skipNulls:!1,strictNullHandling:!1},l=function e(t,r,n,i,a,c,l,s,u,f,p,d){var y=t;if("function"==typeof l)y=l(r,y);else if(y instanceof Date)y=f(y);else if(null===y){if(i)return c&&!d?c(r):r;y=""}if("string"==typeof y||"number"==typeof y||"boolean"==typeof y||o.isBuffer(y)){if(c){return[p(d?r:c(r))+"="+p(c(y))]}return[p(r)+"="+p(String(y))]}var h=[];if(void 0===y)return h;var b;if(Array.isArray(l))b=l;else{var m=Object.keys(y);b=s?m.sort(s):m}for(var v=0;v<b.length;++v){var g=b[v];a&&null===y[g]||(h=Array.isArray(y)?h.concat(e(y[g],n(r,g),n,i,a,c,l,s,u,f,p,d)):h.concat(e(y[g],r+(u?"."+g:"["+g+"]"),n,i,a,c,l,s,u,f,p,d)))}return h};e.exports=function(e,t){var r=e,o=t||{};if(null!==o.encoder&&void 0!==o.encoder&&"function"!=typeof o.encoder)throw new TypeError("Encoder has to be a function.");var a=void 0===o.delimiter?c.delimiter:o.delimiter,s="boolean"==typeof o.strictNullHandling?o.strictNullHandling:c.strictNullHandling,u="boolean"==typeof o.skipNulls?o.skipNulls:c.skipNulls,f="boolean"==typeof o.encode?o.encode:c.encode,p="function"==typeof o.encoder?o.encoder:c.encoder,d="function"==typeof o.sort?o.sort:null,y=void 0!==o.allowDots&&o.allowDots,h="function"==typeof o.serializeDate?o.serializeDate:c.serializeDate,b="boolean"==typeof o.encodeValuesOnly?o.encodeValuesOnly:c.encodeValuesOnly;if(void 0===o.format)o.format=n.default;else if(!Object.prototype.hasOwnProperty.call(n.formatters,o.format))throw new TypeError("Unknown format option provided.");var m,v,g=n.formatters[o.format];"function"==typeof o.filter?(v=o.filter,r=v("",r)):Array.isArray(o.filter)&&(v=o.filter,m=v);var w=[];if("object"!=typeof r||null===r)return"";var x;x=o.arrayFormat in i?o.arrayFormat:"indices"in o?o.indices?"indices":"repeat":"indices";var _=i[x];m||(m=Object.keys(r)),d&&m.sort(d);for(var j=0;j<m.length;++j){var O=m[j];u&&null===r[O]||(w=w.concat(l(r[O],O,_,s,u,f?p:null,v,d,y,h,g,b)))}return w.join(a)}}});
//# sourceMappingURL=2.js.map