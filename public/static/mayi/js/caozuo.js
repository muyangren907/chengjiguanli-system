/**
  扩展cjgl模块
  **/

layui.define(['table', 'form'],function(exports){ //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var table = layui.table
  form = layui.form;
  var obj = {

    // 新建弹窗
    add: function(title,url,width='',height='',max=false){
      xadmin.open(title,url,width,height,max);
    },
    // 新建Tab
    addTab: function(title,url,max=false){
      parent.xadmin.add_tab(title,url,max);
    },

    // 删除单条记录
    del:function(obj,url){
      layer.confirm('确认要删除吗？',function(index){
        $.ajax({
          url:url + '/m',
          type:'DELETE',
          data:{
            id:obj.data.id
          },
          success:function(result){
            if(result.val == 1)
            {
              obj.del();
              layer.msg(result.msg);
            }else{
              layer.msg(result.msg,function(){});
            }
          },
          error:function(result){
            layer.msg('数据扔半道啦。',function(){});
          },
        });
      });
    },

    // 恢复单条记录
    redel:function(obj,url){
      layer.confirm('确认要恢复删除吗？',function(index){
        $.ajax({
          url:url+'/'+obj.data.id,
          type:'DELETE',
          data:{
            id:obj.data.id
          },
          success:function(result){
            if(result.val == 1)
            {
              obj.del();
              layer.msg(result.msg);
            }else{
              layer.msg(result.msg,function(){});
            }
          },
          error:function(result){
            layer.msg('数据扔半道啦。',function(){});
          },
        });
      });
    },

    // 删除全部
    delAll:function(obj,url,tableid){
        //判断是否选择数据
        if(obj.data.length==0){
          parent.layer.msg('请先选择要删除的数据行！',function(){});
          return ;
        }

        layer.confirm('确认要删除吗？',function(index){
          // 捉一下所有被选中的数据
          var ids = "";
          for(var i=0;i<obj.data.length;i++){
            if(i == 0){
              ids= obj.data[i].id;
            }else{
              ids= ids + "," + obj.data[i].id;
            }
          }
          // 到服务器去删除数据。
          $.ajax({
            url:url + '/m',
            type:'DELETE',
            data:{
              id:ids
            },
            success:function(result){
              if(result.val == 1)
              {
                table.reload(tableid, {});
                layer.msg(result.msg);
              }else{
                layer.msg(result.msg,function(){});
              }
            },
            error:function(result){
              layer.msg('数据扔半道，回不来啦。',function(){});
            },
          });
        });
      },

    // 开关操作
    onoff:function(data){
      var obj = {};
      obj.msg = $(data.elem).attr('lay-text').split('|');
      obj.url = $(data.elem).attr('myurl');
      obj.val = {
        'id': data.elem.id
        ,'value': Number(data.elem.checked)
        ,'ziduan': $(data.elem).attr('lay-filter')
      };

      title = obj.msg[1 - obj.val.value];

      layer.confirm('确认要修改成'+title+'吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        $.ajax({
          url:obj.url,
          type:'POST',
          data:obj.val,
          success:function(result){
            if(result.val == 1){
              layer.msg('已修改成：'+title);
            }else{
              layer.msg(result.msg);
            }
          },
          error:function(result){

            layer.msg('数据扔半道啦。',function(){});
          }
        });
      }, function(){
        mydiv = $(data.elem).next('div');
        kg = data.elem.checked;
        if($(mydiv).hasClass("layui-form-onswitch"))
        {
          $(mydiv).removeClass("layui-form-onswitch");
          $(mydiv).children('em').text('禁用');
          $(data.elem).attr('checked', !kg);
          data.elem.checked = !kg;
        }else{
          $(mydiv).addClass("layui-form-onswitch");
          $(mydiv).children('em').text('启用');
          $(data.elem).attr('checked', !kg);
          data.elem.checked = !kg;
        }
      });

    },

    // 重置密码
    resetpassword:function(xingming,url){
      layer.confirm('确认要重置'+xingming+'的密码为“123456”吗？',function(index){
        $.ajax({
          url:url,
          type:'POST',
          success:function(result){
            layer.msg(result.msg);
          },
          error:function(result){
            layer.msg('数据扔半道啦。',function(){});
          },
        });
      });
    },

    // 表格重载
    reLoadTable:function(formname,tableID,mydata={}){
      var formval = this.getSearchVal(formname);
      var wheredata = $.extend(formval,mydata);
      table.reload(tableID,{
        where: formval
        ,done:function(){
          for(x in formval){
            delete this.where[x];
          }
        }
        ,page:{
          curr:1
        }
      });
    },
  };
  //输出test接口
  exports('cjgl', obj);
});
