"use strict";(self.webpackChunk_genially_view_client=self.webpackChunk_genially_view_client||[]).push([[398],{99398:(e,t,n)=>{n.r(t),n.d(t,{LogRocketAnonymousIntegration:()=>p});var o=n(84671),i=n.n(o),r=n(80667),c=n(9795),u=n(36358),a=n(96543),s=function(e,t){var n={};for(var o in e)Object.prototype.hasOwnProperty.call(e,o)&&t.indexOf(o)<0&&(n[o]=e[o]);if(null!=e&&"function"===typeof Object.getOwnPropertySymbols){var i=0;for(o=Object.getOwnPropertySymbols(e);i<o.length;i++)t.indexOf(o[i])<0&&Object.prototype.propertyIsEnumerable.call(e,o[i])&&(n[o[i]]=e[o[i]])}return n},l=r.A.equals,p=function(){function e(){this.uniqueEvents=[],this.isActive=void 0!==i()}return Object.defineProperty(e.prototype,"active",{get:function(){return this.isActive},enumerable:!1,configurable:!0}),e.prototype.start=function(){},e.prototype.trackEvent=function(e){var t=e instanceof a.D;if(this.isActive&&t){var n=!1!==e.payload.unique;if(!n||!this.uniqueEvents.some((function(t){return l(t,e)})))try{!function(e){var t=e.payload,n=t.name,o=t.unique,r=s(t,["name","unique"]);u.A.appEnv!==c.H.Local&&u.A.appEnv!==c.H.Dynamic?i().track(n,r):console.log("This video recording event would be tracked in production",{name:n,unique:!1!==o,eventProperties:r})}(e),n&&this.uniqueEvents.push(e),this.log("Event tracked",e)}catch(o){console.error(o)}}},e.prototype.log=function(e,t){u.A.debug&&console.debug("[LogRocket] ".concat(e),t?{metadata:t}:"")},e}()}}]);
//# sourceMappingURL=https://s3-static-genially.genially.com/view/static/js/398.f1c64dea.chunk.js.map