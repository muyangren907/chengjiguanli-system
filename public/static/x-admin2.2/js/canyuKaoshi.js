/**
  扩展cjgl模块
  **/

layui.extend({
  // 根路径下的具体路径（xmSelect/xmSelect.js）
  xmSelect: "xm-select"
}).define(['table', 'form', 'xmSelect', 'upload'], function(exports) {
  //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var table = layui.table,
    form = layui.form,
    upload = layui.upload,
    xmSelect = layui.xmSelect;

  var obj = {
    nianji:function(myid, data, hasNull = true){
      
    }

  };
  //输出test接口
  exports('canyuKaoshi', obj);
});
