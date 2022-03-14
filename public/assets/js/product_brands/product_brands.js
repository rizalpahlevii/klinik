/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/product_brands/product_brands.js":
/*!**************************************************************!*\
  !*** ./resources/assets/js/product_brands/product_brands.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = "#brandsTbl";
var tbl = $("#brandsTbl").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url: brandsUrl,
    data: function data(_data) {
      _data.status = $("#filter_status").find("option:selected").val();
    }
  },
  columnDefs: [{
    targets: [1],
    orderable: false,
    className: "text-center",
    width: "5%"
  }, {
    targets: "_all",
    defaultContent: "N/A"
  }],
  columns: [{
    data: function data(row) {
      var showLink = brandsUrl + "/" + row.id;
      return '<a href="' + showLink + '">' + row.brand_name + "</a>";
    },
    name: "brand_name"
  }, {
    data: function data(row) {
      var url = brandsUrl + "/" + row.id;
      var data = [{
        id: row.id,
        url: url + "/edit"
      }];
      return prepareTemplateRender("#brandActionTemplate", data);
    },
    name: "id"
  }],
  fnInitComplete: function fnInitComplete() {
    $("#filter_status").change(function () {
      $(tableName).DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on("click", ".delete-btn", function (event) {
  var brandId = $(event.currentTarget).data("id");
  deleteItem(brandsUrl + "/" + brandId, "#brandsTbl", "Merek");
});
$(document).on("click", ".edit-btn", function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var brandId = $(event.currentTarget).data("id");
  renderData(brandId);
});

window.renderData = function (id) {
  $.ajax({
    url: brandsUrl + "/" + id + "/edit",
    type: "GET",
    success: function success(result) {
      if (result.success) {
        var brand = result.data;
        $("#brandId").val(brand.id);
        $("#editName").val(brand.brand_name);
        $("#editModal").modal("show");
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on("submit", "#addNewForm", function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnSave");
  loadingButton.button("loading");
  $.ajax({
    url: brandCreateUrl,
    type: "POST",
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $("#addModal").modal("hide");
        $("#brandsTbl").DataTable().ajax.reload(null, true);
      }
    },
    error: function error(result) {
      printErrorMessage("#validationErrorsBox", result);
    },
    complete: function complete() {
      loadingButton.button("reset");
    }
  });
});
$(document).on("submit", "#editForm", function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnEditSave");
  loadingButton.button("loading");
  var id = $("#brandId").val();
  $.ajax({
    url: brandsUrl + "/" + id,
    type: "put",
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $("#editModal").modal("hide");
        $("#brandsTbl").DataTable().ajax.reload(null, true);
      }
    },
    error: function error(result) {
      UnprocessableInputError(result);
    },
    complete: function complete() {
      loadingButton.button("reset");
    }
  });
});
$("#addModal").on("hidden.bs.modal", function () {
  resetModalForm("#addNewForm", "#validationErrorsBox");
});
$("#editModal").on("hidden.bs.modal", function () {
  resetModalForm("#editForm", "#editValidationErrorsBox");
});

/***/ }),

/***/ 10:
/*!********************************************************************!*\
  !*** multi ./resources/assets/js/product_brands/product_brands.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/product_brands/product_brands.js */"./resources/assets/js/product_brands/product_brands.js");


/***/ })

/******/ });