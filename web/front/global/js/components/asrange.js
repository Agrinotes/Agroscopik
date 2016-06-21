/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2016 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("asRange", {
  mode: "default",
  defaults: {
    tip: true,
    scale: false,
    format: function(value) {
      return value + 'ha';
    },
  }
});
