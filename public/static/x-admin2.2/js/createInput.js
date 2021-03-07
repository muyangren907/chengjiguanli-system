/**
  扩展cjgl模块
  **/

  layui.extend({
      // 根路径下的具体路径（xmSelect/xmSelect.js）
        xmSelect: "xm-select"
    }).define(['table', 'form','xmSelect'], function(exports){
    //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
    var table = layui.table
    ,form = layui.form
    ,xmSelect = layui.xmSelect;

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

        // 查询老师
        searchTeacher: function(id, radio=false)
        {
          school_id = $('#' + id).attr('school_id');
          x = xmSelect.render({
            el: '#' + id, 
            name:id,
            autoRow: true,
            toolbar: { show: true },
            filterable: true,
            remoteSearch: true,
            tips: '请选择教师',
            theme: {
              color: '#1cbbb4',
            },
            prop: {
              name: 'xingming',
              value: 'id',
            },
            height:'25px',
            size: 'mini',
            radio:radio,
            showCount:8,
            repeat: false,
            model: {
              label: {
                type: 'text',
                //使用字符串拼接的方式
                text: {
                  //左边拼接的字符
                  left: '【',
                  //右边拼接的字符
                  right: '】',
                  //中间的分隔符
                  separator: '，',
                },
              }
            },
            remoteMethod: function(val, cb, show){
              //这里如果val为空, 则不触发搜索
              if(!val){
                return cb([]);
              }

              $.ajax({
                url:'/admin/index/adminlist',
                type:'POST',
                data:{
                  searchval:val
                  ,school_id:school_id
                },
                success:function(result){
                  cb(result)
                },
                error:function(result){
                  layer.msg('数据扔半道啦。',function(){});
                },
              });
            },
          })
          return x;
        }

};
  //输出test接口
  exports('createInput', obj);
});
