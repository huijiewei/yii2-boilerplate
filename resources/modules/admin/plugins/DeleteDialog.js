const DeleteDialog = {
  install(Vue, { MessageBox }) {
    Vue.prototype.$deleteDialog = (message, callback) => {
      MessageBox.confirm('<h3>您确定吗?</h3><div>' + message + ' 将被删除.</div>', {
        showClose: false,
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        iconClass: 'anticon anticon-info-circle-o',
        customClass: 'delete-dialog',
        dangerouslyUseHTMLString: true,
        center: true,
        callback: callback
      })
    }
  }
}

export default DeleteDialog
