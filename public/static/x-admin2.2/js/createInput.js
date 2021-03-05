/**
  扩展cjgl模块
  **/

  layui.define(['table', 'form'], function(exports){
    //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    var table = layui.table
    form = layui.form;

    var obj = {
        // 创建的Select
        categorySelect: function(myid, pid, value='', hasNull=true) {
          $.ajax({
              url: '/system/category/children',
              type: 'POST',
              data: {
                  p_id: pid
              },
              success: function(result) {
                if(hasNull == true)
                {
                  str = '<option value=""></option>';
                }else{
                  str = '';
                }
                temp = "";
                $(result.data).each(function (i, el) {
                  if(value != '' && value == el.id)
                  {
                    temp = '<option value="' + el.id + '" selected>' + el.title + '</option>';
                  }else{
                    temp = '<option value="' + el.id + '">' + el.title + '</option>';
                  }
                  str = str + temp;
                });
                $('#' + myid).append(str);
                form.render('select');
              },
              error: function(result) {
                  layer.msg('数据扔半道啦。', function() {});
              },
          });
        },
};
  //输出test接口
  exports('createInput', obj);
});
