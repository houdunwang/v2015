//websocket连接
export default (option) => {
    var options = Object.assign({
        host: '',
        //打开连接时触发
        onopen: () => {
        },
        //服务器返回消息处理
        onmessage: (response) => {
        },
        //关闭连接时触发
        onclose: (response) => {
        },
        //连接错误时触发
        onerror: (response) => {
        },
    }, option);
    let socket = new WebSocket(option.host);
    //打开连接时触发
    socket.onopen = options.onopen;
    //收到消息时触发
    socket.onmessage = options.onmessage;
    //关闭连接时触发
    socket.onclose = options.onmessage;
    //连接错误时触发
    socket.onerror = options.onmessage;
}