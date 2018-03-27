typeof _qha_data !== 'object' && (window._qha_data = {
    domain: 191004,
    host: 's.union.360.cn',
    gu: '151700346.1215878975058899968.1520214492000.7361',
    e360: '2853605555',
    pageClk: null,
    urlClk: 0,
    idClk: null,
    mvid: '402499'
});
!function (t) {
    "use strict";

    function e(t) {
        return It.call(t)
    }

    function n(t) {
        return null !== t && void 0 !== t
    }

    function r(t) {
        return "[object Array]" === e(t)
    }

    function o(t) {
        return "[object Object]" === e(t)
    }

    function i(t) {
        return "[object Function]" === e(t)
    }

    function u(t) {
        if (void 0 === t && (t = null), "object" == typeof JSON && JSON && JSON.stringify) return JSON.stringify(t);
        if (null == t) return "null";
        if ("boolean" == typeof t) return jt(t);
        if ("string" == typeof t) return '"' + t + '"';
        if ("number" == typeof t) return isFinite(t) ? jt(t) : "null";
        if ("object" == typeof t) {
            if (r(t)) {
                for (var e = [], n = 0; n < t.length; n++) e.push(u(t[n]));
                return "[" + e.join(",") + "]"
            }
            var o = [];
            for (var i in t) if (t.hasOwnProperty(i)) {
                var c = t[i];
                void 0 !== c && "function" != typeof c && o.push('"' + i + '":' + u(c))
            }
            return "{" + o.join(",") + "}"
        }
        return ""
    }

    function c(t, e, n) {
        for (var r in t) t.hasOwnProperty(r) && (n = e(n, t[r], r, t));
        return n
    }

    function a(t, e) {
        c(t, function (n, r, o) {
            return e(r, o, t)
        })
    }

    function s(t, e) {
        return c(t, function (n, r, o) {
            return n.push(e(r, o, t)), n
        }, [])
    }

    function f(t, e, n) {
        for (var r = 0; r < t.length; r++) n = e(n, t[r], r, t);
        return n
    }

    function l(t, e, n) {
        f(t, function (n, r, o) {
            return e(r, o, t)
        })
    }

    function p(t, e, n) {
        return f(t, function (n, r, o) {
            return n.push(e(r, o, t)), n
        }, [])
    }

    function d(t) {
        for (var e = [], n = arguments.length - 1; n-- > 0;) e[n] = arguments[n + 1];
        if (!1 === o(t)) throw new Error(t + " is not an object");
        return l(e, function (e) {
            e && o(e) && h(e, t)
        }), t
    }

    function h(t, e) {
        a(t, function (t, n) {
            e[n] = t
        })
    }

    function v(t) {
        if (!1 === o(t)) throw new Error("target is not plain object");
        return s(t, function (t, e) {
            return "object" == typeof t && (t = u(t)), t = null == t ? "" : t, encodeURIComponent(e) + "=" + encodeURIComponent(t)
        }).join("&")
    }

    function m(t) {
        var e = t.indexOf("?");
        if (e < 0) return {base: t, param: {}};
        var n = {};
        return f(t.slice(e + 1).split("&"), function (t, e) {
            var r = e.indexOf("=");
            if (r > -1) {
                var o = e.slice(0, r), i = e.slice(r + 1);
                n[o] = i
            } else n[e] = "";
            return t
        }, n), {base: t.slice(0, e), param: n}
    }

    function g(t, e) {
        return /^https?:\/\/[^/?]+$/.test(t) && (t += "/"), t === e || t.indexOf("*") > -1 && y(t).test(e)
    }

    function y(t) {
        return new Nt(_(t).replace("\\*", ".*"))
    }

    function _(t) {
        return t.replace(/([.*+?^=!:$}{()|[\]/\\])/g, "\\$&")
    }

    function b(e) {
        if (e || (e = t.event), !e) throw new Error("`event` is not an object");
        e.target || (e.target = e.srcElement || Ft), e.target.nodeType === $t && (e.target = e.target.parentNode);
        var n = e.button, r = e.type;
        return Wt.test(r) && !e.which && n && (e.which = 1 & n ? 1 : 2 & n ? 3 : 4 & n ? 2 : 0), e
    }

    function w(t, e, n, r) {
        void 0 === r && (r = !1);
        var o = function (t) {
            t = b(t), n.call(this, t)
        };
        t.addEventListener ? t.addEventListener(e, o, r) : t.attachEvent ? t.attachEvent("on" + e, o) : t["on" + e] = o, n.__dlg = o
    }

    function x(t, e, n, r) {
        var o = n.__dlg;
        t.removeEventListener ? t.removeEventListener(e, o, r) : t.attachEvent ? t.detachEvent("on" + e, o) : t["on" + e] = null, o = null, n.__dlg = null, n = null, t = null
    }

    function k(t, e, n, r) {
        var o = [], u = function (t) {
            var e = this;
            (void 0 === r || i(r) && r(t)) && l(o, function (n) {
                return n.call(e, t)
            })
        }, c = !1, a = new Error("Pool has been destoryed.");
        return w(t, e, u, n), {
            append: function (t) {
                if (c) throw a;
                i(t) && o.push(t)
            }, remove: function (t) {
                if (c) throw a;
                var e = Lt(o, t);
                e > -1 && o.splice(e, 1)
            }, destroy: function () {
                if (c) throw a;
                x(t, e, u, n), o = null, t = null, u = null, c = !0
            }
        }
    }

    function E() {
        var t = -1, e = Ft.body, n = Ft.createElement("div");
        return n.innderHTML = "&nbsp;", n.className = "adsbox adwords", e && (e.appendChild(n), t = 0 === n.offsetWidth ? 1 : 0, e.removeChild(n)), t
    }

    function O(e) {
        var n = "";
        try {
            n = e || t.top.document.referrer
        } catch (t) {
        }
        if ("" === n) return n;
        var r = /^https?:\/\/e\.so\.com\/search\/(eclk|mclick)\?/.exec(n);
        if (r) {
            var o = m(n), i = o.base, u = o.param, c = "mclick" === r[1] ? "asin" : "p";
            n = i + "?" + c + "=" + (u[c] || "")
        } else n = n.slice(0, 1e3);
        return n
    }

    function j() {
        var t = Xt.pixelDepth, e = Xt.colorDepth, n = Xt.width, r = Xt.height, o = Dt.language, i = Dt.browserLanguage;
        return {adb: E(), cl: t || e || 0, ds: n + "x" + r, ln: o || i || "unknown"}
    }

    function C() {
        var e = Ft.documentElement || Ft.body;
        return {
            scrollX: "pageXOffset" in t ? t.pageXOffset : e.scrollLeft,
            scrollY: "pageYOffset" in t ? t.pageYOffset : e.scrollTop
        }
    }

    function S() {
        var t = Ft.documentElement || Ft.body;
        return {width: Bt.max(t.scrollWidth, t.clientWidth), height: Bt.max(t.scrollHeight, t.clientHeight)}
    }

    function N() {
        return void 0 === Ft[Qt] ? "" : Ft[Qt]
    }

    function I() {
        return "preview" === Dt.loadPurpose
    }

    function q() {
        for (var t = [Dt.appName, Dt.version, Dt.language || Dt.browserLanguage, Dt.platform, Dt.userAgent, Xt.width, "x", Xt.height, Xt.colorDepth, Ft.referrer].join(""), e = t.length, n = Mt.length; n;) t += n-- ^ e++;
        return (2147483647 * (Bt.round(2147483647 * Bt.random()) ^ P(t))).toString()
    }

    function P(t) {
        var e = 0, n = 0, r = t.length - 1;
        for (r; r >= 0; r--) {
            var o = Ht(t.charCodeAt(r), 10);
            0 != (n = 4261412864 & (e = (e << 6 & 4294967295) + o + (o << 14))) && (e ^= n >> 21)
        }
        return e
    }

    function A(t) {
        ee && (ne.setAttribute("href", t), t = ne.href), ne.setAttribute("href", t);
        var e = ne.href, n = ne.protocol, r = ne.host, o = ne.search, i = ne.hash, u = ne.hostname, c = ne.port,
            a = ne.pathname;
        return {
            href: e,
            protocol: n ? n.replace(/:$/, "") : "",
            host: r,
            search: o ? o.replace(/^\?/, "") : "",
            hash: i ? i.replace(/^#/, "") : "",
            hostname: u,
            port: c,
            pathname: "/" === a.charAt(0) ? a : "/" + a
        }
    }

    function L(t, e, n) {
        if (!t || !t.length) return !1;
        var r = Ht(t[t.length - 1], 10);
        return !(Bt.abs(e - r) > ue) && !T(O(), n)
    }

    function T(t, e) {
        var n = A(t).hostname, r = n.indexOf(e);
        return !(r >= 0 && n.slice(r) === e)
    }

    function V(t, e, n, r) {
        void 0 === n && (n = "image");
        var o = v(e);
        if (o.length <= 2048 && "beacon" !== n) return R(t, o, r);
        f(n in ye ? ye[n] : [0, 1, 2], function (e, n) {
            return e || ge[n](t, o, r)
        }, !1)
    }

    function R(e, n, r) {
        var o = "qha_log_" + Bt.floor(2147483648 * Bt.random()).toString(36), i = new t.Image;
        t[o] = i, i.onload = i.onerror = i.onabort = function () {
            i.onload = i.onerror = i.onabort = null, i = t[o] = null, r && r()
        }, n = ve && n.length > 8153 ? n.slice(8153) : n;
        var u = me(n, "im");
        return i.src = F(e, u), !0
    }

    function U(e, n, r) {
        var o = t.XDomainRequest;
        if (!o) return !1;
        try {
            var i = new o, u = me(n, "xdr");
            return i.open("POST", e), setTimeout(function () {
                return i.send(u)
            }), i.onload = i.onerror = function () {
                r && r()
            }, !0
        } catch (t) {
            return !1
        }
    }

    function F(t, e) {
        return t + (t.indexOf("?") > -1 ? "&" : "?") + e
    }

    function J(t) {
        i(t) && (be += 1, t.i = be, we.push(t))
    }

    function D(t, e, n) {
        l(we, function (r) {
            i(r) && r.i > 0 && r(t, e, r.i ? n : void 0)
        })
    }

    function X(t) {
        return !1 === n(t) ? "" : Ee("" + t)
    }

    function M(t) {
        var e = X("" + t);
        if ("object" == typeof JSON && JSON && JSON.parse) return JSON.parse(e);
        var n, r = null, o = e.replace(Oe, function (t, e, o, i) {
            return n && e && (r = 0), 0 === r ? t : (n = o || e, r += !i - !o, "")
        });
        if (e && !X(o)) return new Et[kt]("return " + e)();
        throw new Error("Invalid JSON: " + t)
    }

    function B(t, e, n) {
        if ("send" === t && n && 0 === n.index) {
            var r = e[0];
            if ((r && r.et) >= xt) {
                var o = null;
                try {
                    o = M(te.get("mediav"))
                } catch (t) {
                }
                d(r, o)
            }
        }
    }

    function H(t, e, n) {
        if ("send" === t && n && 0 === n.index) {
            var r = e[0], o = r && r.et;
            o !== mt && o !== gt || d(r, Y())
        }
    }

    function Y() {
        var e = {};
        return t._e360_uid && d(e, {
            e_uid: t._e360_uid || "",
            e_cid: t._e360_campaignid || "",
            e_gid: t._e360_groupid || "",
            e_yid: t._e360_creativeid || "",
            e_kid: t._e360_keywordid || "",
            e_clkid: t._e360_clickid || "",
            e_type: t._e360_type || "",
            e_query: t._e360_query || "",
            e_mtype: t._e360_matchtype || "",
            e_smtype: t._e360_submatchtype || ""
        }), t._e360_commerce && (e.e_com = t._e360_commerce), t._e360_sip && (e.e_sip = t._e360_sip), e
    }

    function $(e, n) {
        t.postMessage && t.top !== t && t.top.postMessage(u({type: e, args: n}), "*")
    }

    function W(t, e) {
        1 === t ? je.push(e) : Ce.push(e)
    }

    function z(t, e) {
        l(1 === t ? je : Ce, function (t) {
            i(t) && t(e)
        })
    }

    function G(t) {
        for (var e = 0; e < t.length; e += 1) t[e](Se)
    }

    function K() {
        var t = Ne;
        Ie && t.length && (Ne = [], G(t))
    }

    function Q() {
        Ie || (Ie = !0, pe && clearInterval(pe), K())
    }

    function Z(t) {
        Ie ? t(Se) : Ne.push(t)
    }

    function tt(t) {
        Z(function () {
            return nt(t)
        })
    }

    function et(e) {
        t[vt]("send", {et: _t, msg: e})
    }

    function nt(e) {
        var n = e.domain, r = e.currentPV, o = e.mvid, i = null;
        if (o && !(r.index > 0)) {
            if (qe) return et("wx");
            if (143225 != +n) {
                1 === E() && et("adb");
                try {
                    i = Ft.createElement('<iframe name="' + o + '"></iframe>')
                } catch (t) {
                    (i = Ft.createElement("iframe")).name = o
                }
                i.height = 0, i.width = 0, i.border = 0, i.style.display = "none", i.src = Pe + "/mv.html", i.onload = null, rt(i, o), Ft.body ? Ft.body.appendChild(i) : w(t, "load", function () {
                    Ft.body.appendChild(i)
                })
            }
        }
    }

    function rt(e, n) {
        var r = n.split(","), o = function (t) {
            return t.indexOf(Pe) > -1
        }, i = function (t, e) {
            return t && ("mid" === t || Lt(r, t) > -1)
        }, c = function (e, n) {
            if ("mid" === e) return t[vt]("send", {et: wt, mid: n});
            var r = n.split(","), o = r[0];
            void 0 === o && (o = "");
            var i = r[1];
            void 0 === i && (i = "");
            var c = r[2];
            void 0 === c && (c = "");
            var a = {eid: e, ep: o, vid: i, ctn: c};
            te.set("mediav", u(a)), t[vt]("send", d({et: yt}, a))
        }, a = function (t) {
            var e = t.origin, n = ("" + t.data).split("|"), r = n[0], u = n[1];
            o(e) && i(r) && c(r, u)
        };
        "postMessage" in t ? w(t, "message", a) : Dt._qha_message = function (t) {
            return a({origin: Pe, data: t})
        }
    }

    function ot(e) {
        var n = e.currentPV.start, r = {et: gt, ep: Vt() - n};
        t[vt]("send", r, "beacon")
    }

    function it(t) {
        var e = !1;
        return function () {
            if (!e) return e = !0, t.apply(this, arguments)
        }
    }

    function ut(t, e, n) {
        void 0 === e && (e = Et), void 0 === n && (n = Et);
        var r = Ft.getElementsByTagName("script")[0], o = Ft.createElement("script");
        o.type = "text/javascript", o.defer = !0, o.async = !0, o.src = t, o.onerror = n, o.onload = e, o.onreadystatechange = function (t) {
            var n = o.readyState;
            "loaded" !== n && "complete" !== n || e(t)
        }, r.parentNode.insertBefore(o, r)
    }

    function ct(t, e) {
        return Te = p(t, function (t) {
            var n = new t(e);
            return Le.append(n.listener), n
        })
    }

    function at() {
        Te && l(Te, function (t) {
            return t.update()
        })
    }

    function st(t, e) {
        if (!t) return [];
        var n = c(t, function (t, n, r) {
            return g(r, e) && t.push(n), t
        }, []).join(",").split(",");
        return At(n)
    }

    function ft(t) {
        for (var e = t.id; !e && (t = t.parentNode);) e = t.id;
        return t
    }

    function lt(t) {
        for (var e = t.target, n = {t: e.nodeName}, r = 0; r < 3 && e && "A" !== e.nodeName;) r++, e = e.parentNode;
        return n.u = e && "A" === e.nodeName ? e.href : "", n
    }

    function pt(t) {
        var e = t.pageX;
        void 0 === e && (e = 0);
        var n = t.pageY;
        return void 0 === n && (n = 0), {x: e, y: n}
    }

    function dt(t, e) {
        var n = s(t, function (t, e) {
            return e + ":" + encodeURIComponent(t)
        }), r = s(e, function (t, e) {
            return e + ":" + encodeURIComponent(t)
        });
        return n.concat(r).join(",")
    }

    function ht(t, e) {
        if (!t || 0 === t.length) return !1;
        for (var n = 0; n < t.length; n++) if (g(t[n], e)) return !0;
        return !1
    }

    var vt = "_qha", mt = 0, gt = 3, yt = 20, _t = 21, bt = 11, wt = 6, xt = 30, kt = "constructor", Et = function () {
    }, Ot = function (t) {
        return t
    }, jt = ""[kt], Ct = {}[kt], St = [][kt], Nt = /s/[kt];
    "function" != typeof Ct.create && (Ct.create = function (t) {
        function e() {
        }

        return e.prototype = t, new e
    });
    var It = Ct.prototype.toString, qt = St.prototype.slice, Pt = function (t) {
            return r(t) ? t : t.length && t.item ? p(t, Ot) : qt.call(t)
        }, At = function (t) {
            return f(t, function (t, e) {
                return Lt(t, e) < 0 && t.push(e), t
            }, [])
        }, Lt = i([].indexOf) ? function (t, e) {
            return t.indexOf(e)
        } : function (t, e) {
            if (e != e) return -1;
            for (var n = 0; n < t.length; n++) if (t[n] === e) return n;
            return -1
        }, Tt = function () {
            return +new Date
        }, Vt = function () {
            return +new Date / 1e3 | 0
        }, Rt = function (t) {
            return new Date(Tt() + 864e5 * t)
        }, Ut = function (t) {
            var e = t.callback, n = t.timeout, r = !1, o = null, u = function () {
                r || (r = !0, clearTimeout(o), i(e) && e())
            };
            return o = setTimeout(u, +n || 1e3), u
        }, Ft = t.document, Jt = t.location, Dt = t.navigator, Xt = t.screen, Mt = t.history, Bt = t.Math, Ht = t.parseInt,
        Yt = "https:" === Jt.protocol ? "https:" : "http:", $t = 3,
        Wt = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, zt = "";
    if (void 0 === Ft.hidden) for (var Gt = ["webkit", "moz", "ms", "o"], Kt = 0; Kt < Gt.length; Kt++) if (void 0 !== Ft[Gt[Kt] + "Hidden"]) {
        zt = Gt[Kt];
        break
    }
    for (var Qt = "" === zt ? "visibilityState" : zt + "VisibilityState", Zt = k(Ft, zt + "visibilitychange", !0), te = {
        get: function (t) {
            t = encodeURIComponent(t);
            var e = Nt("(^| )" + t + "=([^;]*)(;|$)").exec(Ft.cookie);
            return decodeURIComponent(e ? e[2] : "")
        }, set: function (t, e, n) {
            void 0 === n && (n = {});
            var r = encodeURIComponent(t) + "=" + encodeURIComponent(e), o = n.path, i = n.domain, u = n.expires;
            r += u ? ";expires=" + Rt(u).toUTCString() : "", r += o ? ";path=" + o : "", r += i ? ";domain=" + i : "";
            try {
                Ft.cookie = r
            } catch (t) {
            }
        }, del: function (t, e) {
            this.set(t, "", d({expires: -1}, e))
        }
    }, ee = /(msie|trident)/i.test(Dt.userAgent), ne = Ft.createElement("a"), re = Ft.domain.split("."), oe = "." + re.pop(); re.length;) if (oe = "." + re.pop() + oe, te.set("__qhart", "1", {domain: oe}), "1" === te.get("__qhart")) {
        te.del("__qhart", {domain: oe});
        break
    }
    var ie = oe.slice(1), ue = 28800, ce = 0, ae = function (t) {
        var e = t.referrer, n = t.domainId, r = t.url, o = t.conf, i = t.init;
        void 0 === i && (i = Et), this.index = ce++, this.conf = o, this.url = r, this.domainId = n, this.start = Vt(), this.referrer = e, this.session = new he({
            key: "qs_lvt_" + n,
            ident: Vt(),
            domain: ie
        }), this.page = new de({key: "qs_pv_" + n, ident: q(), domain: ie}), i.call(this)
    };
    ae.prototype.getBaseInfo = function () {
        var t = function (t) {
                return t.slice(-2).reverse()
            }, e = this, n = e.url, r = e.start, o = e.referrer, i = e.domainId, u = e.page, c = e.session, a = e.conf,
            s = a.gu, f = a.version, l = t(u.list), p = l[0], d = l[1], h = t(c.list), v = h[0], m = h[1],
            g = {url: n, si: i, su: o, flt: r, lt: v, pt: p, guid: s, v: f};
        return m && (g.lt2 = m), d && (g.pt2 = d), g
    };
    var se = function (t) {
        var e = t.key, n = t.ident, r = t.domain, o = t.expires;
        void 0 === o && (o = 365);
        var i = {path: "/", domain: "." + r};
        this.cfg = d({expires: o}, i);
        var u = this.migrate(e, i);
        this.ident = "" + n, this.key = u.key, this.list = u.list
    };
    se.prototype.migrate = function (t, e) {
        var n = te.get(t), r = t.replace(/^[a-z]/, function (t) {
            return t.toUpperCase()
        });
        "" !== n && "" === te.get(r) && te.set(r, n, this.cfg), te.del(t, e);
        var o = te.get(r);
        return {key: r, list: "" === o ? [] : o.split(",")}
    }, se.prototype.init = function () {
        var t = this, e = t.list, n = t.key, r = t.ident, o = t.cfg;
        this.list = e.slice(-4).concat(r), te.set(n, this.list.join(","), o)
    };
    var fe, le, pe, de = function (t) {
            function e(e) {
                t.call(this, e), this.init()
            }

            return t && (e.__proto__ = t), e.prototype = Object.create(t && t.prototype), e.prototype.constructor = e, e
        }(se), he = function (t) {
            function e(e) {
                t.call(this, e);
                var n = !L(this.list, this.ident, ie);
                this.isNew = n, n && this.init()
            }

            return t && (e.__proto__ = t), e.prototype = Object.create(t && t.prototype), e.prototype.constructor = e, e
        }(se), ve = /chrome/i.test(Dt.userAgent), me = function (t, e) {
            return t + (t.length > 0 ? "&" : "") + "_mtd=" + e
        }, ge = [function (t, e, n) {
            return !(!_e || !Dt.sendBeacon(t, e && me(e, "bc")) || (n && n(), 0))
        }, function (e, n, r) {
            var o = t.XMLHttpRequest;
            if (!o) return !1;
            var i = new o;
            if ("withCredentials" in i == 0) return U(e, n, r);
            try {
                var u = me(n, "xhr");
                return i.open("POST", e, !0), i.withCredentials = !0, i.setRequestHeader("Content-Type", "text/plain"), i.onreadystatechange = function () {
                    i.readyState >= 2 && r && r()
                }, i.onerror = function () {
                    r && r()
                }, i.send(u), !0
            } catch (t) {
                return !1
            }
        }, R], ye = {image: [2, 0, 1], xhr: [1, 0, 2], beacon: [0, 2, 1]}, _e = i(Dt.sendBeacon), be = 0, we = [],
        xe = jt.prototype.trim, ke = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, Ee = i(xe) ? function (t) {
            return xe.call(t)
        } : function (t) {
            return t.replace(ke, "")
        },
        Oe = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g,
        je = [], Ce = [], Se = Ft, Ne = [], Ie = !1;
    if ("complete" === Ft.readyState) Q(); else if (Ft.addEventListener) Ft.addEventListener("DOMContentLoaded", Q, !1), t.addEventListener("load", Q, !1); else if (t.attachEvent) {
        t.attachEvent("onload", Q), le = Ft.createElement("div");
        try {
            fe = null === t.frameElement
        } catch (t) {
        }
        le.doScroll && fe && t.external && (pe = setInterval(function () {
            try {
                le.doScroll(), Q()
            } catch (t) {
            }
        }, 30))
    }
    var qe = /micromessenger/.test(Dt.userAgent.toLowerCase()), Pe = Yt + "//360fenxi.mediav.com", Ae = function (e) {
        var n = e.currentPV, r = n.index, o = n.session.isNew, i = e.e360, u = i && 0 === r && o,
            c = d({et: mt, ck: 0 | !o}, j()), a = it(function () {
                return t[vt]("send", c)
            });
        u ? (ut(Yt + "//e.so.com/search/c.js?u=" + i, a, a), setTimeout(a, 500)) : a()
    }, Le = k(Ft, "mousedown", !0), Te = null, Ve = function (t) {
        this.cf = t
    };
    Ve.prototype.update = function (t) {
        throw new Error("`update()` method not implemented")
    }, Ve.prototype.listener = function (t) {
        throw new Error("`listener()` method not implemented")
    }, Ve.prototype.send = function (e, n) {
        t[vt]("send", e, n)
    };
    var Re = function (t) {
            function e(e) {
                var n = this;
                t.call(this, e), e.idClk ? (this.map = e.idClk, this.matches = [], this.listener = function (t) {
                    var e = ft(t.target), r = e && e.id;
                    r && Lt(n.matches, r) > -1 && n.send({et: bt, ep: r})
                }) : this.listener = Et
            }

            return t && (e.__proto__ = t), e.prototype = Object.create(t && t.prototype), e.prototype.constructor = e, e.prototype.update = function () {
                this.matches = st(this.map, this.cf.currentPV.url)
            }, e
        }(Ve), Ue = function (t) {
            function e(e) {
                var n = this;
                t.call(this, e), this.clk = 1 == +e.urlClk, this.listener = function (t) {
                    return n.clk && n.resp(t)
                }, this.update = Et
            }

            return t && (e.__proto__ = t), e.prototype = Object.create(t && t.prototype), e.prototype.constructor = e, e.prototype.resp = function (t) {
                var e = lt(t), n = e.u;
                n && !/^\s*javascript:/.test(n) && this.send({et: 2, ep: dt(e, pt(t))}, "beacon")
            }, e
        }(Ve), Fe = function (t) {
            function e(e) {
                var n = this;
                t.call(this, e), this.list = e.pageClk, this.trk = !1, this.listener = function (t) {
                    n.trk && n.clk(t)
                }
            }

            return t && (e.__proto__ = t), e.prototype = Object.create(t && t.prototype), e.prototype.constructor = e, e.prototype.update = function () {
                this.trk = ht(this.list, this.cf.currentPV.url)
            }, e.prototype.clk = function (t) {
                var e = t.clientX, n = t.clientY, r = C(), o = r.scrollX, i = r.scrollY, u = S(), c = u.width, a = u.height;
                this.send({et: 10, x: e + o, y: n + i, w: c, h: a})
            }, e
        }(Ve), Je = {}, De = d({version: "3.0.2", currentPV: null}, o(!1) && !1 || t._qha_data), Xe = De.domain,
        Me = Yt + "//" + De.host + "/s.gif";
    t._qha_ldt_ = (t._qha_ldt_ || 0) + 1, R(Me, v({
        et: 100,
        si: Xe,
        ldt: t._qha_ldt_,
        vis: N(),
        prv: +I(),
        guid: De.gu,
        t: Tt(),
        v: "3.0.2"
    }));
    var Be = function (t) {
        var e = null == De.currentPV;
        !1 === e && z(-1, De), De.currentPV = new ae({
            referrer: e ? O() : De.currentPV.url,
            domainId: Xe,
            url: t ? A(t).href : Jt.href,
            conf: De
        }), z(1, De)
    }, He = function () {
        W(-1, ot), W(1, tt), W(1, Ae), W(1, function () {
            return at()
        }), ct([Ue, Re, Fe], De), J(B), J(H), J($)
    }, Ye = {
        set: function (t, e) {
            Je[t] = e
        }, send: function () {
            for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
            if ("pageview" === t[0]) return Be(Je.page);
            var n = t[0], r = "string" == typeof t[1] ? t[1] : Je.transport, u = null;
            o(t[1]) ? u = Ut(t[1]) : o(t[2]) && (u = Ut(t[2])), d(n, De.currentPV.getBaseInfo(), {t: Tt()});
            var c = [Me, n, r, u], a = Je.pingGuard;
            i(a) && !0 !== a.apply(null, c) || V.apply(null, c)
        }
    }, $e = function (t) {
        var e = Pt(t), n = e[0], r = e.slice(1), o = Ye[n];
        D(n, r, De.currentPV), i(o) && o.apply(null, r)
    };
    I() || function (t) {
        var e = function () {
            return "prerender" === N()
        };
        e() ? Zt.append(function () {
            !1 === e() && (t(), Zt.destroy())
        }) : t()
    }(function () {
        if (!t[vt] || 1 !== t[vt].__) {
            if (!1 === i(t[vt])) {
                var e = function () {
                    for (var t = [], n = arguments.length; n--;) t[n] = arguments[n];
                    (e.c = e.c || []).push(t)
                };
                t[vt] = e
            }
            He(), t[vt]("init", Xe);
            var n = t[vt];
            n && r(n.c) && n.c.length && (t[vt].s || n.c.unshift(["send", "pageview"]), l(n.c, $e)), t[vt] = function () {
                for (var t = [], e = arguments.length; e--;) t[e] = arguments[e];
                return $e(t)
            }, t[vt].__ = 1, w(t, "unload", function () {
                return z(-1, De)
            })
        }
    })
}(this);


(function () {
    function k() {
        this.c = "1263870579";
        this.ca = "z";
        this.Z = "";
        this.W = "";
        this.Y = "";
        this.C = "1520209465";
        this.aa = "z8.cnzz.com";
        this.X = "";
        this.G = "CNZZDATA" + this.c;
        this.F = "_CNZZDbridge_" + this.c;
        this.P = "_cnzz_CV" + this.c;
        this.R = "CZ_UUID" + this.c;
        this.L = "UM_distinctid";
        this.H = "0";
        this.K = {};
        this.a = {};
        this.Aa()
    }

    function g(a,
               b) {
        try {
            var c = [];
            c.push("siteid=1263870579");
            c.push("name=" + f(a.name));
            c.push("msg=" + f(a.message));
            c.push("r=" + f(h.referrer));
            c.push("page=" + f(e.location.href));
            c.push("agent=" + f(e.navigator.userAgent));
            c.push("ex=" + f(b));
            c.push("rnd=" + Math.floor(2147483648 * Math.random()));
            (new Image).src = "http://jserr.cnzz.com/log.php?" + c.join("&")
        } catch (d) {
        }
    }

    var h = document, e = window, f = encodeURIComponent, m = decodeURIComponent, r = unescape;
    k.prototype = {
        Aa: function () {
            try {
                this.ja(), this.V(), this.wa(), this.T(), this.za(),
                    this.w(), this.ua(), this.ta(), this.xa(), this.o(), this.sa(), this.va(), this.ya(), this.qa(), this.oa(), this.ra(), this.Ea(), e[this.F] = e[this.F] || {}, this.pa("_cnzz_CV")
            } catch (a) {
                g(a, "i failed")
            }
        }, Ca: function () {
            try {
                var a = this;
                e._czc = {
                    push: function () {
                        return a.M.apply(a, arguments)
                    }
                }
            } catch (b) {
                g(b, "oP failed")
            }
        }, oa: function () {
            try {
                var a = e._czc;
                if ("[object Array]" === {}.toString.call(a)) for (var b = 0; b
                < a.length; b++) {
                    var c = a[b];
                    switch (c[0]) {
                        case "_setAccount":
                            e._cz_account = "[object String]" === {}.toString.call(c[1]) ?
                                c[1] : String(c[1]);
                            break;
                        case "_setAutoPageview":
                            "boolean" === typeof c[1] && (e._cz_autoPageview = c[1])
                    }
                }
            } catch (d) {
                g(d, "cS failed")
            }
        }, Ea: function () {
            try {
                if ("undefined" === typeof e._cz_account || e._cz_account === this.c) {
                    e._cz_account = this.c;
                    if ("[object Array]" === {}.toString.call(e._czc)) for (var a = e._czc, b = 0, c = a.length; b
                    < c; b++) this.M(a[b]);
                    this.Ca()
                }
            } catch (d) {
                g(d, "pP failed")
            }
        }, M: function (a) {
            try {
                if ("[object Array]" === {}.toString.call(a)) switch (a[0]) {
                    case "_trackPageview":
                        if (a[1]) {
                            this.a.f = "https://" +
                                e.location.host;
                            "/" !== a[1].charAt(0) && (this.a.f += "/");
                            this.a.f += a[1];
                            if ("" === a[2]) this.a.g = ""; else if (a[2]) {
                                var b = a[2];
                                "http" !== b.substr(0, 4) && (b = "https://" + e.location.host, "/" !== a[2].charAt(0) && (b += "/"), b += a[2]);
                                this.a.g = b
                            }
                            this.s();
                            "undefined" !== typeof this.a.g && delete this.a.g;
                            "undefined" !== typeof this.a.f && delete this.a.f
                        }
                        break;
                    case "_trackEvent":
                        var c = [];
                        a[1] && a[2] && (c.push(f(a[1])), c.push(f(a[2])), c.push(a[3] ? f(a[3]) : ""), a[4] = parseFloat(a[4]), c.push(isNaN(a[4]) ? 0 : a[4]), c.push(a[5] ?
                            f(a[5]) : ""), this.v = c.join("|"), this.s(), delete this.v);
                        break;
                    case "_setCustomVar":
                        if (3 <= a.length) {
                            if (!a[1] || !a[2]) return !1;
                            var d = a[1], l = a[2], n = a[3] || 0;
                            a = 0;
                            for (var h in this.a.b) a++;
                            if (5 <= a) return !1;
                            var p;
                            0 == n ? p = "p" : -1 == n || -2 == n ? p = n : p = (new Date).getTime() + 1E3 * n;
                            this.a.b[d] = {};
                            this.a.b[d].da = l;
                            this.a.b[d].h = p;
                            this.I()
                        }
                        break;
                    case "_deleteCustomVar":
                        2 <= a.length && (d = a[1], this.a.b[d] && (delete this.a.b[d], this.I()));
                        break;
                    case "_trackPageContent":
                        a[1] && (this.D = a[1], this.s(), delete this.D);
                    case "_trackPageAction":
                        c =
                            [];
                        a[1] && a[2] && (c.push(f(a[1])), c.push(f(a[2])), this.u = c.join("|"), this.s(), delete this.u);
                        break;
                    case "_setUUid":
                        var m = a[1];
                        if (128
                            < m.length) return !1;
                        var k = new Date;
                        k.setTime(k.getTime() + 157248E5);
                        this.ba(this.R, m, k)
                }
            } catch (u) {
                g(u, "aC failed")
            }
        }, ra: function () {
            try {
                var a = this.m(this.P), b, c;
                this.a.b = {};
                if (a) for (var d = a.split("&"), a = 0; a
                < d.length; a++) c = m(d[a]), b = c.split("|"), this.a.b[m(b[0])] = {}, this.a.b[m(b[0])].da = m(b[1]), this.a.b[m(b[0])].h = m(b[2])
            } catch (l) {
                g(l, "gCV failed")
            }
        }, ka: function () {
            try {
                var a =
                    (new Date).getTime(), b;
                for (b in this.a.b) "p" === this.a.b[b].h ? this.a.b[b].h = 0 : "-1" !== this.a.b[b].h && a > this.a.b[b].h && delete this.a.b[b];
                this.I()
            } catch (c) {
                g(c, "cCV failed")
            }
        }, I: function () {
            try {
                var a = [], b, c, d;
                for (d in this.a.b) {
                    var l = [];
                    l.push(d);
                    l.push(this.a.b[d].da);
                    l.push(this.a.b[d].h);
                    b = l.join("|");
                    a.push(b)
                }
                if (!a.length) return !0;
                var e = new Date;
                e.setTime(e.getTime() + 157248E5);
                c = this.P + "=";
                this.b = f(a.join("&"));
                c += this.b;
                c += "; expires=" + e.toUTCString();
                h.cookie = c + "; path=/"
            } catch (t) {
                g(t, "sCV failed")
            }
        },
        qa: function () {
            try {
                if ("" !== e.location.hash) return this.O = e.location.href
            } catch (a) {
                g(a, "gCP failed")
            }
        }, o: function () {
            try {
                return this.a.Fa = h.referrer || ""
            } catch (a) {
                g(a, "gR failed")
            }
        }, sa: function () {
            try {
                return this.a.A = e.navigator.systemLanguage || e.navigator.language, this.a.A = this.a.A.toLowerCase(), this.a.A
            } catch (a) {
                g(a, "gL failed")
            }
        }, va: function () {
            try {
                return e.screen.width && e.screen.height ? this.a.J = e.screen.width + "x" + e.screen.height : this.a.J = "0x0", this.a.J
            } catch (a) {
                g(a, "gS failed")
            }
        }, w: function () {
            try {
                return this.a.Ba =
                    this.i("ntime") || "none"
            } catch (a) {
                g(a, "gLVST failed")
            }
        }, U: function () {
            try {
                return this.a.ea = this.i("ltime") || (new Date).getTime()
            } catch (a) {
                g(a, "gFVBT failed")
            }
        }, ua: function () {
            try {
                var a = this.i("cnzz_a");
                if (null === a) a = 0; else {
                    var b = 1E3 * this.w(), c = new Date;
                    c.setTime(b);
                    (new Date).getDate() === c.getDate() ? a++ : a = 0
                }
                return this.a.Ja = a
            } catch (d) {
                g(d, "gRT failed")
            }
        }, ta: function () {
            try {
                return this.a.B = this.i("rtime"), null === this.a.B && (this.a.B = 0), 0
                < this.U() && 432E5 < (new Date).getTime() - this.U() && (this.a.B++, this.a.ea =
                    (new Date).getTime()), this.a.B
            } catch (a) {
                g(a, "gRVT failed")
            }
        }, xa: function () {
            try {
                return "none" === this.w() ? this.a.Ia = 0 : this.a.Ia = parseInt(((new Date).getTime() - 1E3 * this.w()) / 1E3)
            } catch (a) {
                g(a, "gST failed")
            }
        }, wa: function () {
            try {
                var a = this.i("sin") || "none";
                if (!h.domain) return this.a.Ha = "none";
                this.o().split("/")[2] !== h.domain && (a = this.o());
                return this.a.Ha = a
            } catch (b) {
                g(b, "gS failed")
            }
        }, T: function () {
            try {
                return this.a.l = this.i("cnzz_eid") || "none"
            } catch (a) {
                g(a, "gC failed")
            }
        }, Ga: function () {
            try {
                var a = "https://c.cnzz.com/core.php?",
                    b = [];
                b.push("web_id=" + f(this.c));
                this.Z && b.push("show=" + f(this.Z));
                this.Y && b.push("online=" + f(this.Y));
                this.W && b.push("l=" + f(this.W));
                this.ca && b.push("t=" + this.ca);
                a += b.join("&");
                this.na(a, "utf-8")
            } catch (c) {
                g(c, "rN failed")
            }
        }, ja: function () {
            try {
                return !1 === e.navigator.cookieEnabled ? this.a.ma = !1 : this.a.ma = !0
            } catch (a) {
                g(a, "cCE failed")
            }
        }, ba: function (a, b, c, d, e, g) {
            a = f(a) + "=" + f(b);
            c instanceof Date && (a += "; expires=" + c.toGMTString());
            d && (a += "; path=" + d);
            e && (a += "; domain=" + e);
            g && (a += "; secure");
            h.cookie = a
        },
        m: function (a) {
            try {
                a += "=";
                var b = h.cookie, c = b.indexOf(a), d = "";
                if (-1
                    < c) {
                    var e = b.indexOf(";", c);
                    -1 === e && (e = b.length);
                    d = m(b.substring(c + a.length, e))
                }
                return d ? d : ""
            } catch (n) {
                g(n, "gAC failed")
            }
        }, pa: function (a) {
            try {
                h.cookie = a + "=; expires=" + (new Date(0)).toUTCString() + "; path=/"
            } catch (b) {
                g(b, "dAC failed")
            }
        }, ya: function () {
            try {
                var a = h.title;
                40
                < a.length && (a = a.substr(0, 40), a += "...");
                this.a.Da = a
            } catch (b) {
                g(b, "gT failed")
            }
        }, N: function (a) {
            try {
                return "http" !== a.substr(0, 4) ? "" : /https:\/\/.*?\//i.exec(a)
            } catch (b) {
                g(b,
                    "cH failed")
            }
        }, V: function () {
            try {
                var a = this.G, b = {}, c = this.m(this.G);
                if (0
                    < c.length) if (1E8
                    < this.c) {
                    var d = c.split("|");
                    b.cnzz_eid = m(d[0]);
                    b.ntime = m(d[1])
                } else for (var d = c.split("&"), e = 0, f = d.length; e
                < f; e++) {
                    var h = d[e].split("=");
                    b[m(h[0])] = m(h[1])
                }
                this.K = b
            } catch (p) {
                g(p, "iC failed:" + a + ":" + c)
            }
        }, $: function () {
            try {
                var a = this.G + "=", b = [], c = new Date;
                c.setTime(c.getTime() + 157248E5);
                if (1E8
                    < this.c) {
                    if ("none" !== this.a.l) b.push(f(this.a.l)); else {
                        var d = Math.floor(2147483648 * Math.random()) + "-" + this.C + "-" + this.N(this.o());
                        b.push(f(d))
                    }
                    b.push(this.C);
                    0
                    < b.length ? (a += f(b.join("|")), a += "; expires=" + c.toUTCString(), a += "; path=/") : a += "; expires=" + (new Date(0)).toUTCString()
                } else "none" !== this.a.l ? b.push("cnzz_eid=" + f(this.a.l)) : (d = Math.floor(2147483648 * Math.random()) + "-" + this.C + "-" + this.N(this.o()), b.push("cnzz_eid=" + f(d))), b.push("ntime=" + this.C), 0
                < b.length ? (a += f(b.join("&")), a += "; expires=" + c.toUTCString(), a += "; path=/") : a += "; expires=" + (new Date(0)).toUTCString();
                h.cookie = a
            } catch (l) {
                g(l, "sS failed")
            }
        }, i: function (a) {
            try {
                return "undefined" !==
                typeof this.K[a] ? this.K[a] : null
            } catch (b) {
                g(b, "gCPa failed")
            }
        }, na: function (a, b) {
            try {
                if (b = b || "utf-8", "1" === this.H) {
                    var c = h.createElement("script");
                    c.type = "text/javascript";
                    c.async = !0;
                    c.charset = b;
                    c.src = a;
                    var d = h.getElementsByTagName("script")[0];
                    d.parentNode && d.parentNode.insertBefore(c, d)
                } else h.write(r("%3Cscript src='" + a + "' charset='" + b + "' type='text/javascript'%3E%3C/script%3E"))
            } catch (l) {
                g(l, "cAS failed")
            }
        }, ha: function (a, b) {
            try {
                var c = h.getElementById("cnzz_stat_icon_" + this.c);
                if (c) {
                    var d = h.createElement("script");
                    d.type = "text/javascript";
                    d.async = !0;
                    d.charset = b;
                    d.src = a;
                    c.appendChild(d)
                } else "0" === this.H && h.write(r("%3Cscript src='" + a + "' charset='" + b + "' type='text/javascript'%3E%3C/script%3E"))
            } catch (l) {
                g(l, "cSI failed")
            }
        }, ga: function (a) {
            try {
                for (var b = a.length, c = "", d = 0; d
                < b; d++) a[d] && (c += r(a[d]));
                var e = h.getElementById("cnzz_stat_icon_" + this.c);
                e ? e.innerHTML = c : "0" === this.H && h.write(c)
            } catch (n) {
                g(n, "cI failed")
            }
        }, s: function () {
            try {
                this.$();
                this.V();
                this.T();
                this.ka();
                var a = this.m(this.R), b = [];
                b.push("id=" + f(this.c));
                this.a.g || "" === this.a.g ? b.push("r=" + f(this.a.g)) : b.push("r=" + f(this.a.Fa));
                b.push("lg=" + f(this.a.A));
                b.push("ntime=" + f(this.a.Ba));
                b.push("cnzz_eid=" + f(this.a.l));
                b.push("showp=" + f(this.a.J));
                this.a.f ? b.push("p=" + f(this.a.f)) : "[object String]" === {}.toString.call(this.O) && b.push("p=" + f(this.O));
                "[object String]" === {}.toString.call(this.v) && b.push("ei=" + f(this.v));
                "[object String]" === {}.toString.call(this.b) && b.push("cv=" + this.b);
                "[object String]" === {}.toString.call(this.D) && b.push("pc=" + f(this.D));
                "[object String]" === {}.toString.call(this.u) && b.push("ai=" + this.u);
                a && b.push("uuid=" + f(a));
                b.push("t=" + f(this.a.Da));
                b.push("umuuid=" + f(this.a.S));
                b.push("h=1");
                var c = b.join("&");
                "[object String]" === {}.toString.call(this.v) ? this.j(["https://ei.cnzz.com/stat.htm?" + c]) : this.D || this.u ? this.j(["https://ca.cnzz.com/stat.htm?" + c]) : (this.X && this.j(["https://" + this.X + "/stat.htm?" + c]), this.aa && this.j(["https://" + this.aa + "/stat.htm?" + c]))
            } catch (d) {
                g(d,
                    "sD failed")
            }
        }, fa: function () {
            function a() {
                function a(a, b) {
                    var c, d = 0;
                    for (c = 0; c
                    < b.length; c++) d |= h[c] << 8 * c;
                    return a ^ d
                }

                var b = e.navigator.userAgent, f, g, h = [], k = 0;
                for (f = 0; f
                < b.length; f++) g = b.charCodeAt(f), h.unshift(g & 255), 4 <= h.length && (k = a(k, h), h = []);
                0
                < h.length && (k = a(k, h));
                return k.toString(16)
            }

            function b() {
                for (var a = 1 * new Date, b = 0; a == 1 * new Date;) b++;
                return a.toString(16) + b.toString(16)
            }

            return function () {
                var c = (e.screen.height * e.screen.width).toString(16);
                return b() + "-" + Math.random().toString(16).replace(".",
                    "") + "-" + a() + "-" + c + "-" + b()
            }
        }(), za: function () {
            try {
                var a = this.a, b;
                if (!(b = this.m(this.L))) {
                    var c = this.fa(), d = new Date;
                    d.setTime(d.getTime() + 157248E5);
                    var e = document.location.hostname.match(/[a-z0-9][a-z0-9\-]+\.[a-z\.]{2,6}$/i);
                    this.ba(this.L, c, d, "/", e ? e[0] : "");
                    b = c
                }
                a.S = b;
                return this.a.S
            } catch (n) {
                g(n, "gC failed")
            }
        }, j: function (a) {
            try {
                for (var b = a.length, c = null, d = 0; d
                < b; d++) a[d] && (c = "cnzz_image_" + Math.floor(2147483648 * Math.random()), e[c] = new Image, e[c].la = c, e[c].onload = e[c].onerror = e[c].onabort = function () {
                    try {
                        this.onload =
                            this.onerror = this.onabort = null, e[this.la] = null
                    } catch (l) {
                    }
                }, e[c].src = a[d] + "&rnd=" + Math.floor(2147483648 * Math.random()))
            } catch (l) {
                g(l, "cR failed")
            }
        }, ia: function () {
            for (var a = e.navigator.userAgent.toLowerCase(), b = 0; 12 > b; b++) if (-1
                < a.indexOf("#mobileconf#"[b])) return "mobile";
            return "pc"
        }
    };
    try {
        var q = new k;
        e[q.F].bobject = q;
        !1 !== e._cz_autoPageview ? q.s() : q.$();
        k.prototype.getACookie = k.prototype.m;
        k.prototype.callRequest = k.prototype.j;
        k.prototype.createScriptIcon = k.prototype.ha;
        k.prototype.createIcon = k.prototype.ga;
        q.Ga();
        q.ia()
    } catch (a) {
        g(a, "main failed")
    }
})();
