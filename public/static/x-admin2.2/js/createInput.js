/**
  扩展cjgl模块
  **/

  layui.define(['table', 'form'], function(exports){
    //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    var table = layui.table
    form = layui.form;

    var obj = {
        // 创建类别的Select
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


        // 选中子后代的复选框
        checkboxChildren:function(cid, check){
          edit(cid, check);
          function edit(cid, check)
          {
            $("input[pid='" + cid + "']").each(function(i,el){
              this.checked = check;
              cid = $(this).attr('cid');
              edit(cid, check);
            });
          }
          form.render('checkbox');
        },


        // 选中父级的复选框
        checkboxParent:function(pid, check){
          if(check == true)
          {
            edit(pid, check)
          }
          ;
          function edit(pid, check)
          {
            $("input[cid='" + pid + "']").each(function(i,el){
              this.checked = check;
              pid = $(this).attr('pid');
              edit(pid, check);
            });
          }
          form.render('checkbox');
        },


        // 创建单位的Select
        schoolSelect: function(myid, low='班级', high='其它级', value, hasNull=true) {
          $.ajax({
              url: '/system/school/srcschool',
              type: 'POST',
              data: {
                low:low,
                high:high
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
