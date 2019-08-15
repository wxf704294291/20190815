layui.use('layedit', function () {
    var layedit = layui.layedit
        , $ = layui.jquery;

    //构建一个默认的编辑器
    var index = layedit.build('LAY_demo1', {
        height: 120,
        tool: ['face', 'image'],
        uploadImage: {
            url: send_image_url,
            type: 'post'
        }
    });

    $(".get_value").click(function () {
        var val = $(".quick_reply").text()
        $("index").text(val)
    })

    //编辑器外部操作
    var active = {
        content: function () {
            alert(layedit.getContent(index)); //获取编辑器内容
        }
        , text: function () {
            alert(layedit.getText(index)); //获取编辑器纯文本内容
        }
        , selection: function () {
            alert(layedit.getSelection(index));
        }
    };

    $('.site-demo-layedit').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    $('.j-send-msg').click(function () {
        var content = layedit.getContent(index);
        dscmallKefu.message.msg = content;
        dscmallEvent.sendEnterMsg();
    });

    $('#LAY_layedit_1').contents().keydown(function (event) {
        switch (event.keyCode) {
            case 13 :
                event.preventDefault();
                dscmallKefu.message.msg = layedit.getContent(index);
                dscmallEvent.sendEnterMsg();
                break;
            case 116 :
                event.returnValue = false;
                event.keyCode = 0;
                event.cancelBubble = true;
                return false;
        }
    });
});

var dscmallEvent = {
    vueobj: {},
    audio: null,
    target_service: {uid: "", uname: null},
    init: function () {
        this.vueapp();

        // 客服列表
        this.chat_history_list();

        // 初始化当前客服信息
        this.init_service_data();

        // 声音
        dscmallEvent.audio = new Audio(audio_path);

    },
    chat_history_list : function () {
        //  客服列表
        var that = this;
        $.ajax({
            url : chat_list_rul,
            async : false,
            success : function (res) {

                for (let i in res) {
                    that.vueobj.$set(that.vueobj.service_list, res[i].service_id, res[i]);
                }
                delete res;
            }
        });
    },
    init_service_data : function (data) {
        // 初始化 客服
        let current_ru_id = 0, i = 0, is_exist_list = false;

        for ( i in this.vueobj.service_list ) {

            if ( this.vueobj.service_list[i].ru_id == dscmallKefu.user.store_id || dscmallKefu.user.store_id === 0 ) {
                //  列表存在该商家
                is_exist_list = true;
                this.vueobj.current_target = this.vueobj.service_list[i].service_id;
                break;
            }
        }

        /**
         * 不存在列表中  （ 首次与该商家联系 ）
         * 查询商家信息  ( 非自营 )  加入客服列表
         * 从商品进入 查询商品信息   显示商品信息
         */
        if ( is_exist_list == false ) {
            let d = {
                add_time : dscmallKefu.SystemDate(),
                count : 0,
                message : "您好",
                ru_id : dscmallKefu.user.store_id,
                service_id : 0,
                shop_name : dscmallKefu.user.store_name,
                thumb :  dscmallKefu.user.store_logo
            };
            this.vueobj.$set(this.vueobj.service_list, 0, d);
            /**
             * 将消息添加到页面
             */
            d.avatar = dscmallKefu.user.store_logo;
            d.from_id = d.service_id;
            d.message = d.message;
            d.message_type = '';
            d.name = dscmallKefu.user.store_name;
            d.service_id = d.service_id;
            d.store_id = d.ru_id;
            d.time = d.add_time;
            dscmallEvent.add_message(d, 2);
        }

        dscmallEvent.vueobj.change_service(dscmallEvent.vueobj.current_target);

        //
        //this.vueobj.service_list[data.service_id] = {
        //    add_time: dscmallKefu.SystemDate(),
        //    count : 1,
        //    isShow : 1,
        //    message : data.msg,
        //    ru_id : data.ru_id,
        //    service_id : data.service_id,
        //    shop_name : data.name,
        //    thumb : data.avatar
        //};
        //
        //this.vueobj.service_list_chat_data[data.service_id] = {
        //    chat : [],
        //    count : 0,
        //    goods : {}
        //};

    },
    service_list_chat_data : function (service_id){
        // 获取 客服对应聊天记录  只做第一次查询

        if ( service_id === '' ) {
            return ;
        }
        var that = this;

        if (
            that.vueobj.service_list_chat_data[service_id] != undefined && that.vueobj.service_list_chat_data[service_id] != ''
            && that.vueobj.service_list_chat_data[service_id].goods != undefined
        ) {
            return ;
        }

        $.ajax({
            url : service_list_chat_data_url,
            data : {
                id : service_id,
                type : "default",
                goods_id : dscmallKefu.user.goods_id
            },
            success : function (res) {
                res.chat.reverse();
                if (
                    that.vueobj.service_list_chat_data[service_id] == undefined || that.vueobj.service_list_chat_data[service_id] == ''
                    || that.vueobj.service_list_chat_data[service_id].goods == undefined
                ) {

                    if (that.vueobj.service_list_chat_data[service_id] != undefined ) {
                        res.chat = [];
                        let chat = that.vueobj.service_list_chat_data[service_id].chat;
                        for ( let i in chat ) {
                            res.chat.push(chat[i]);
                        }
                    }
                    that.vueobj.$set(that.vueobj.service_list_chat_data, service_id, res);
                }
            }
        });


    },
    add_message: function (data, warp_chat) {

        let d = {
            warp_chat: (warp_chat == 1) ? 'warp-chat-right' : 'warp-chat-left',
            user_picture: (warp_chat == 1) ? dscmallKefu.user.avatar : data.avatar,
            user_name: data.name,
            add_time: data.time,
            message: data.message
        };

        let service_id = data.from_id || this.vueobj.current_target;

        if (service_id == '') {
            this.vueobj.current_target = 0;
            service_id = 0;
        }

        if (this.vueobj.service_list_chat_data[service_id] == undefined) {
            // 还没聊天数据
            if ( this.vueobj.service_list[service_id] == undefined ) {

                this.vueobj.$set(this.vueobj.service_list, service_id, {
                    add_time : data.time,
                    count : 0,
                    message : data.message,
                    ru_id : dscmallKefu.user.store_id,
                    service_id : data.from_id || "0",
                    shop_name : dscmallKefu.user.store_name,
                    thumb : dscmallKefu.user.store_logo
                });

            }

            chat = [];

            this.vueobj.$set(this.vueobj.service_list[service_id], "count", 1);

            chat.push(d);
            this.vueobj.$set(this.vueobj.service_list_chat_data, service_id, {chat});

        }else {

            // 已有聊天数据
            chat = [...this.vueobj.service_list_chat_data[service_id].chat];

            this.vueobj.service_list[service_id].count = parseInt(this.vueobj.service_list[service_id].count) + 1;

            chat.push(d);
            this.vueobj.service_list_chat_data[service_id].chat = chat;

        }

        // 本人或者 正在聊天对象  计数为0
        if (warp_chat == 1 || this.vueobj.current_target == service_id) {
            this.vueobj.service_list[service_id].count = 0;
        }

        // 将消息同步到客服列表 显示
        this.vueobj.service_list[service_id].message = data.message;

    },
    sendEnterMsg: function () {
        dscmallKefu.message.type = 'sendmsg';
        dscmallKefu.message.to_id = dscmallEvent.target_service.uid;
        dscmallKefu.message.avatar = dscmallKefu.user.avatar;
        dscmallKefu.message.store_id = dscmallEvent.target_service.store_id;
        dscmallKefu.message.goods_id = dscmallKefu.user.goods_id;
        dscmallKefu.message.origin = dscmallKefu.come_form;
        dscmallKefu.sendmsg();
        $('#LAY_layedit_1').contents().find('body').html("");
        $('#LAY_layedit_1').contents().find('body').focus();
    },
    vueapp: function () {
        /** 客服聊天 */
        this.vueobj = new Vue({
            el: '#chat_list',
            data: {
                current_target: 0,
                cont: "",
                message_list: [{
                    warp_chat: 'success',
                    user_picture: '',
                    user_name: '',
                    add_time: '',
                    message: '欢迎您',
                }],
                user_name : dscmallKefu.user.user_name,
                user_avatar : dscmallKefu.user.avatar,
                service_list : [],
                service_list_chat_data : [],
                chat_data_page_list: [],
                search_contact : ""
            },
            methods: {
                change_service : function ( service_id, event ) {
                    // 切换商家

                    if ( service_id === '' ) {
                        return ;
                    }

                    this.current_target = service_id;

                    dscmallEvent.service_list_chat_data( service_id );
                    // 未读数量清零
                    if (this.service_list[service_id] != undefined && this.service_list[service_id].count != undefined) {
                        this.service_list[service_id].count = 0;
                    }
                    //
                    dscmallEvent.target_service = {
                        uid: service_id,
                        store_id : (event == undefined) ? dscmallKefu.user.store_id : event.currentTarget.getAttribute("data-ruid")
                    };
                },
                get_more_msg : function () {
                    // 查看更多消息
                    let page = (this.chat_data_page_list[this.current_target] || 0);
                    if ( page < 0 )
                        return;

                    this.$set(this.chat_data_page_list, this.current_target, page + 1)

                    dscmallEvent.get_more_msg(page + 1, this.service_list[this.current_target].ru_id);
                }
            },
            computed: {
                evenNumbers: function () {
                    if (this.service_list_chat_data[this.current_target] == undefined)
                        return;

                    //
                    return this.service_list_chat_data[this.current_target].chat.filter(function (list) {

                        if (list.warp_chat == undefined || list.warp_chat == '') {
                            list.warp_chat = list.user_type;
                        }

                        list.warp_chat = (list.warp_chat == 2 || list.warp_chat == 'warp-chat-right') ? 'warp-chat-right' : 'warp-chat-left'
                        list.user_picture = (list.warp_chat == 2 || list.warp_chat == 'warp-chat-right') ? dscmallKefu.user.avatar : ( list.avatar == undefined ) ? list.user_picture : list.avatar
                        list.user_name = list.name || list.user_name
                        list.add_time = list.time || list.add_time
                        if (list.message != undefined) {
                            list.message.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, "&quot;").replace(/'/g, "&#039;");

                        }

                        return true;
                    })
                },
                service_list_computer : function () {

                    return this.service_list.filter(function (list) {
                        list.message = list.message.replace(/<img\b[^>]*src\s*=\s*"[^>"]*\.(?:png|jpg|bmp|gif)"[^>]*>/, '[图片]');
                        return true;
                    });
                }
            },
            filters : {
                filter_shop_name : function (value) {
                    if (!value) return ''
                    value = value.toString();
                    return value.indexOf("自营") > 0 ? "自营" : "店铺"
                },
                filter_time : function (time) {
                    return time.substring(0, time.indexOf(" "));
                }
            },
            watch: {
                evenNumbers: {
                    deep: true,
                    handler(val, oldVal) {
                        this.$nextTick(() => {
                            let oTank = $('#tank')
                            oTank.scrollTop($('#tank ul').outerHeight() - $(".tank-con").height());
                    })
                    }
                },
                search_contact : {
                    deep: true,
                    handler(val, oldVal) {
                        this.service_list = this.service_list.map(function (item) {
                            if (item.shop_name.indexOf(val) > -1) {
                                item.isShow = 1;
                            }else {
                                item.isShow = 0;
                            }

                            return item;
                        });
                    }
                }
            }
        });
        //  vue end


    },
    come_message: function (data) {
        // 消息接收

        dscmallEvent.audio.play();
        dscmallEvent.add_message(data, 2);

    },

    get_service: function (data) {
        // 客服接入
        if ( this.vueobj.current_target == data.service_id ||  this.vueobj.current_target == 0 ) {
            dscmallEvent.target_service.uid = data.service_id;
            this.vueobj.current_target = data.service_id;

        }
        // 合并 客服列表
        for (let i in this.vueobj.service_list) {

            if ( this.vueobj.service_list[i].ru_id == data.store_id &&
                (this.vueobj.service_list[i].service_id === 0 || this.vueobj.service_list[i].service_id === "0")
            ) {

                dscmallEvent.add_message({
                    avatar : this.vueobj.service_list[i].avatar,
                    from_id : data.service_id,
                    message : this.vueobj.service_list[i].message,
                    message_type : '',
                    msg : this.vueobj.service_list[i].message,
                    name : dscmallKefu.user.user_name,
                    service_id : data.service_id,
                    store_id : this.vueobj.service_list[i].ru_id,
                    time : this.vueobj.service_list[i].add_time,
                }, 1);

                delete this.vueobj.service_list[i];
                delete this.vueobj.service_list_chat_data[i];
                break;
            }
        }
        //
        data.message = data.msg;
        data.from_id = data.service_id;
        data.time = dscmallKefu.SystemDate();
        if (data.msg != '') {
            dscmallEvent.add_message(data, 2);
        }

    },
    get_more_msg : function (page, store_id) {
        // 查看更多消息
        let that = this;
        $.ajax({
            url : get_more_msg_url,
            data : {
                page : page,
                default : 1,
                store_id : store_id
            },
            success : function (res) {
                let data = dscmallKefu.json_encode(res)

                if (data.error == 1) {
                    that.vueobj.$set(that.vueobj.chat_data_page_list, that.vueobj.current_target, -1)
                    return;
                }
                // 添加到消息记录里

                let chat = that.vueobj.service_list_chat_data[that.vueobj.current_target].chat;
                for ( let i in data ) {
                    chat.unshift(data[i]);
                }
                that.vueobj.service_list_chat_data[that.vueobj.current_target].chat = chat;

            }
        });
    },
    close_link: function (data) {
        //客服断开
        $('#jw-come-msg').append('<li><div class="success">' + data.msg + '</div></li>');
        dscmallEvent.target_service = {};
        $("#tank").scrollTop(($('.tank-con').outerHeight() + $("#jw-get-more").outerHeight()) - $("#tank").height());
    },
    others_login: function (data) {
        layer.confirm('您已在其他页面发起咨询，当前咨询已失效， 请点击按钮重新咨询!', {
            btn: ['确认刷新'], //按钮
            title: "提示",
            closeBtn: false,
            move : false,
            maxWidth : "500px"
        }, function(){
            // 第一个回调
            window.location.reload(true);
        });
    }

};

//layui   end
document.onkeydown = function () {
//        if (event.keyCode == 116) {
//            event.returnValue = false;
//            event.keyCode = 0;
//            event.cancelBubble = true;
//            return false;
//        }
};


layui.use('element', function () { });