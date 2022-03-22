(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./resources/js/src/views/apps/mapping-tier/mapping-tier-list/useMappingTierList.js":
/*!******************************************************************************************!*\
  !*** ./resources/js/src/views/apps/mapping-tier/mapping-tier-list/useMappingTierList.js ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return useMappingTierList; });
/* harmony import */ var _vue_composition_api__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @vue/composition-api */ "./node_modules/@vue/composition-api/dist/vue-composition-api.mjs");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/store */ "./resources/js/src/store/index.js");
/* harmony import */ var vue_toastification_composition__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-toastification/composition */ "./node_modules/vue-toastification/composition/index.js");
/* harmony import */ var vue_toastification_composition__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_toastification_composition__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _core_components_toastification_ToastificationContent_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @core/components/toastification/ToastificationContent.vue */ "./resources/js/src/@core/components/toastification/ToastificationContent.vue");

 // Notification



function useMappingTierList() {
  // Use toast
  var toast = Object(vue_toastification_composition__WEBPACK_IMPORTED_MODULE_2__["useToast"])();
  var refMappingTierListTable = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null); // Table Handlers

  var tableColumns = [{
    key: 'id',
    label: 'ID',
    sortable: true
  }, {
    key: 'leadtype',
    label: 'Lead Type',
    sortable: true
  }, {
    key: 'buyer_id',
    label: 'Buyer ID',
    sortable: true
  }, {
    key: 'buyer_setup_id',
    label: 'Tier ID',
    sortable: true
  }, {
    key: 'status',
    label: 'Status',
    sortable: true
  }, {
    key: 'actions'
  }];
  var perPage = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(10);
  var totalMappingTier = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(0);
  var currentPage = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(1);
  var perPageOptions = [10, 25, 50, 100];
  var searchQuery = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])('');
  var sortBy = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])('id');
  var isSortDirDesc = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(true);
  var leadTypeFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var buyerFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var tierFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var statusFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var dataMeta = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["computed"])(function () {
    var localItemsCount = refMappingTierListTable.value ? refMappingTierListTable.value.localItems.length : 0;
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalMappingTier.value
    };
  });

  var refetchData = function refetchData() {
    refMappingTierListTable.value.refresh();
  };

  Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["watch"])([currentPage, perPage, searchQuery, leadTypeFilter, buyerFilter, tierFilter, statusFilter], function () {
    refetchData();
  });

  var fetchMappingTiers = function fetchMappingTiers(ctx, callback) {
    _store__WEBPACK_IMPORTED_MODULE_1__["default"].dispatch("app-mapping-tier/getMappingTiers/", {
      q: searchQuery.value,
      perPage: perPage.value,
      page: currentPage.value,
      sortBy: sortBy.value,
      sortDesc: isSortDirDesc.value,
      leadType: leadTypeFilter.value,
      buyer: buyerFilter.value,
      tier: tierFilter.value,
      status: statusFilter.value
    }).then(function (response) {
      var mappingTierData = response.data.mappingTierData;
      console.log(mappingTierData);
      debugger;
      callback(mappingData.data);
      totalMappingTier.value = mappingData.total;
    })["catch"](function () {
      toast({
        component: _core_components_toastification_ToastificationContent_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
        props: {
          title: 'Error fetching MappingTier list',
          icon: 'AlertTriangleIcon',
          variant: 'danger'
        }
      });
    });
  };

  var fetchMappingTier = function fetchMappingTier(ctx, callback) {
    _store__WEBPACK_IMPORTED_MODULE_1__["default"].dispatch('app-mapping-tier/fetchMappingTier', {
      q: searchQuery.value,
      perPage: perPage.value,
      page: currentPage.value,
      sortBy: sortBy.value,
      sortDesc: isSortDirDesc.value,
      leadType: leadTypeFilter.value,
      buyer: buyerFilter.value,
      tier: tierFilter.value,
      status: statusFilter.value
    }).then(function (response) {
      var _response$data = response.data,
          mapping = _response$data.mapping,
          total = _response$data.total;
      console.log(response.data);
      console.log(mapping);
      console.log(total);
      debugger;
      callback(mapping);
      totalMappingTier.value = total;
    })["catch"](function () {
      toast({
        component: _core_components_toastification_ToastificationContent_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
        props: {
          title: 'Error fetching MappingTier list',
          icon: 'AlertTriangleIcon',
          variant: 'danger'
        }
      });
    });
  };

  function goBack() {
    history.back();
  } // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*


  var resolveMappingTierRoleVariant = function resolveMappingTierRoleVariant(leadType) {
    if (leadType === 'subscriber') return 'primary';
    if (leadType === 'author') return 'warning';
    if (leadType === 'maintainer') return 'success';
    if (leadType === 'editor') return 'info';
    if (leadType === 'admin') return 'danger';
    return 'primary';
  };

  var resolveMappingTierRoleIcon = function resolveMappingTierRoleIcon(leadType) {
    if (leadType === 'subscriber') return 'BuyerSetupIcon';
    if (leadType === 'author') return 'SettingsIcon';
    if (leadType === 'maintainer') return 'DatabaseIcon';
    if (leadType === 'editor') return 'Edit2Icon';
    if (leadType === 'admin') return 'ServerIcon';
    return 'BuyerSetupIcon';
  };

  var resolveMappingTierStatusVariant = function resolveMappingTierStatusVariant(status) {
    if (status === 'pending') return 'warning';
    if (status === 'active') return 'success';
    if (status === 'inactive') return 'secondary';
    return 'primary';
  };

  var resolveMappingTierModeVariant = function resolveMappingTierModeVariant(status) {
    if (status === 'inactive') return 'warning';
    if (status === 'live') return 'success';
    if (status === 'test') return 'secondary';
    return 'primary';
  };

  var resolveMappingTierModelTypeVariant = function resolveMappingTierModelTypeVariant(model_type) {
    if (model_type === 'CPA') return 'warning';
    if (model_type === 'CPL') return 'success';
    if (model_type === 'CPF') return 'secondary';
    if (model_type === 'Hybrid') return 'secondary';
    return 'primary';
  };

  var resolveMappingTierRotationVariant = function resolveMappingTierRotationVariant(rotation) {
    if (rotation === 1) return 'success';
    if (rotation === 0) return 'warning';
    return 'primary';
  };

  var leadTypeOptions = [{
    label: 'UK',
    value: 1
  }, {
    label: 'USA',
    value: 2
  }];
  var statusOptions = [{
    label: 'Active',
    value: 1
  }, {
    label: 'Inactive',
    value: 0
  }];
  return {
    fetchMappingTiers: fetchMappingTiers,
    tableColumns: tableColumns,
    perPage: perPage,
    currentPage: currentPage,
    totalMappingTier: totalMappingTier,
    dataMeta: dataMeta,
    perPageOptions: perPageOptions,
    searchQuery: searchQuery,
    sortBy: sortBy,
    isSortDirDesc: isSortDirDesc,
    refMappingTierListTable: refMappingTierListTable,
    resolveMappingTierRoleVariant: resolveMappingTierRoleVariant,
    resolveMappingTierRoleIcon: resolveMappingTierRoleIcon,
    resolveMappingTierStatusVariant: resolveMappingTierStatusVariant,
    resolveMappingTierModeVariant: resolveMappingTierModeVariant,
    resolveMappingTierModelTypeVariant: resolveMappingTierModelTypeVariant,
    resolveMappingTierRotationVariant: resolveMappingTierRotationVariant,
    refetchData: refetchData,
    // Extra Filters
    leadTypeFilter: leadTypeFilter,
    buyerFilter: buyerFilter,
    tierFilter: tierFilter,
    statusFilter: statusFilter,
    statusOptions: statusOptions,
    leadTypeOptions: leadTypeOptions,
    goBack: goBack,
    fetchMappingTier: fetchMappingTier
  };
}

/***/ }),

/***/ "./resources/js/src/views/apps/mapping-tier/mappingTierStoreModule.js":
/*!****************************************************************************!*\
  !*** ./resources/js/src/views/apps/mapping-tier/mappingTierStoreModule.js ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @axios */ "./resources/js/src/libs/axios.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchMappingTiers: function fetchMappingTiers(ctx, queryParams) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get('/admin/mappings', {
          params: queryParams
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchMappingTierIDs: function fetchMappingTierIDs(ctx, queryParams) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get('/admin/getMappingTierIDs', {
          params: queryParams
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchMappingTier: function fetchMappingTier(ctx, _ref) {
      var id = _ref.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("/admin/mappings/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    getMappingTiers: function getMappingTiers(ctx, _ref2) {
      var id = _ref2.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("/admin/mappings/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    addTier: function addTier(ctx, mappingData) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].post('/admin/mappings', {
          mappingTier: mappingData
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    updateMappingTier: function updateMappingTier(_ref3, mappingData) {
      var commit = _ref3.commit;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].patch("/admin/mappings/".concat(mappingData.id), mappingData) // .post(`/user/${user.id}`, user)
        .then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    deleteMappingTier: function deleteMappingTier(ctx, _ref4) {
      var id = _ref4.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"]["delete"]("/admin/mappings/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchFilterDataOptions: function fetchFilterDataOptions(ctx, queryParams) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get('/admin/fetchFilterDataOptions', {
          params: queryParams
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    }
  }
});

/***/ })

}]);