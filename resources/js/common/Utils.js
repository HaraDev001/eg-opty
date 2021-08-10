export default {

  install(Vue, options) {

    Vue.prototype.$utils = {
      format: function(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      // async imgDimension(url) {
      //   var img = new Image();
      //   var height = 0;
      //   var width = 0;
      //   img.onload = function(){
      //     var height = img.height;
      //     var width = img.width;
      //   }
      //   await img.src = url;
      //   return {width: width, height: height}
      // }
    }
  }
}