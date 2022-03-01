var token_key = "admin_token";
var user_key = "admin_user";
var expires_key = "expires_in";
var login_url = "/admin/login";
var refesh_token_url = "/admin/index/refresh_token";

function save_token(token) {
    save_web_temp_data(token_key, token);
}

function clean_token() {
    del_web_temp_data(token_key);
}

function save_expires_in(expires) {
    save_web_temp_data(expires_key, expires);
}

function clean_expires_in() {
    del_web_temp_data(expires_key);
}

function save_user_info(user) {
    save_web_temp_data(user_key, user);
}

Vue.prototype.get_user = function () {
    var user = get_web_temp_data(user_key);
    return user;
}

function check_login(url) {
    if (!get_user()) {
        logout(url);
        return false;
    }
    if (!(get_web_temp_data(expires_key) > (new Date().getTime()))) {
        logout(url);
        return false;
    }
    if (!((get_web_temp_data(expires_key) - (1000 * 60 * 20)) > (new Date().getTime()))) {
        refresh_token(refesh_token_url);
    }
    return true;
}

function refresh_token(url) {
    var token = get_web_temp_data(token_key);
    if (token && token.length > 0) {
        Vue.http.headers.common['Authorization'] = "Bearer " + token;
    }
    Vue.http.post(
        url,
        {},
        {emulateJSON: true}
    ).then(
        function (response) {
            if (response.status) {
                switch (response.status) {
                    case 20000:
                        save_token(response.data.token);
                        save_expires_in((response.data.expires_in * 1000) + (new Date().getTime()));
                        break;
                    default:
                        break;
                }
            }
        }, function (response) {

        }
    )
}

function clean_user_info() {
    del_web_temp_data(user_key);
}

function logout_server(url, jump_url) {
    addBodyload();
    request_ajax_json(url, {}, function () {
        clean_token();
        clean_user_info();
        clean_expires_in();
        if (jump_url && jump_url.length > 0) {
            removeBodyload();
            window.location.href = jump_url;
        } else {
            removeBodyload();
            window.location.href = login_url
        }
    },function () {
        removeBodyload();
    });
}

function logout(url) {
    clean_token();
    clean_user_info();
    clean_expires_in();
    if (url && url.length > 0) {
        window.location.href = url;
    } else {
        window.location.href = login_url
    }
}

function request_ajax_json(url, json, callback, callback_err) {
    var token = get_web_temp_data(token_key);
    if (token && token.length > 0) {
        Vue.http.headers.common['Authorization'] = "Bearer " + token;
    }
    Vue.http.post(
        url,
        json,
        {emulateJSON: true}
    ).then(
        function (response) {
            if (response.data.status && response.data.status > 70000) {
                logout();
            }
            callback(response.data);
        }, function (response) {
            if (response.data.status && response.data.status > 60000) {
                logout();
            }
            var error = "系統忙碌中，請您稍後重新嘗試。";
            if(response.data.message&&response.data.message.length>0){
                error = response.data.message;
            }
            // 響應錯誤
            Swal.fire({
                title: "ERROR",
                text: error,
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
            }).then(function (result) {
                if (result.value) {
                }
            });
            callback_err(response.data);
        }
    )
}

function request_ajax_form_data(url, form_data, callback, callback_err) {
    var token = get_web_temp_data(token_key);
    if (token && token.length > 0) {
        Vue.http.headers.common['Authorization'] = "Bearer " + token;
    }
    Vue.http.post(
        url,
        form_data,
        {'Content-Type': 'Multipart/form-data'}
    ).then(
        function (response) {
            if (response.data.status && response.data.status > 70000) {
                logout();
            }
            callback(response.data);
        }, function (response) {
            if (response.data.status && response.data.status > 60000) {
                logout();
            }
            var error = "系統忙碌中，請您稍後重新嘗試。";
            if(response.data.message&&response.data.message.length>0){
                error = response.data.message;
            }
            // 響應錯誤
            Swal.fire({
                title: "ERROR",
                text: error,
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
            }).then(function (result) {
                if (result.value) {
                }
            });
            callback_err(response.data);
        }
    )
}

function deep_copy(obj) {
    var result, oClass = Object.prototype.toString.call(obj).slice(8, -1);
    if (oClass == "Object") result = {}; //判斷傳入的如果是對象，繼續遍歷
    else if (oClass == "Array") result = []; //判斷傳入的如果是數組，繼續遍歷
    else return obj; //如果是基本數據類型就直接返回

    for (var i in obj) {
        var copy = obj[i];

        if (Object.prototype.toString.call(copy).slice(8, -1) == "Object") result[i] = deep_copy(copy); //遞歸方法 ，如果對象繼續變量obj[i],下一級還是對象，就obj[i][i]
        else if (Object.prototype.toString.call(copy).slice(8, -1) == "Array") result[i] = deep_copy(copy); //遞歸方法 ，如果對象繼續數組obj[i],下一級還是數組，就obj[i][i]
        else result[i] = copy; //基本數據類型則賦值給屬性
    }
    return result;
}

function save_web_temp_data(name, obj) {
    if (window.Storage && window.localStorage && window.localStorage instanceof Storage) {
        var storage = window.localStorage;
        storage.setItem(name, JSON.stringify(obj));
    } else {
        $.cookie(name, JSON.stringify(cookie_data), {path: '/'});
    }
}

function get_web_temp_data(name) {
    var data = null;
    if (window.Storage && window.localStorage && window.localStorage instanceof Storage) {
        var storage = window.localStorage;
        data = JSON.parse(storage.getItem(name));
    } else {
        if ($.cookie(name)) {
            data = JSON.parse($.cookie(name));
        }
    }
    return data;
}

function del_web_temp_data(name) {
    if (window.Storage && window.localStorage && window.localStorage instanceof Storage) {
        var storage = window.localStorage;
        storage.removeItem(name);
    } else {
        if ($.cookie(name)) {
            $.removeCookie(name, {path: '/'});
        }
    }
}