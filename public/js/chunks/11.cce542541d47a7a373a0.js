(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./resources/js/src/views/apps/filter/filter-list/useFilterList.js":
/*!*************************************************************************!*\
  !*** ./resources/js/src/views/apps/filter/filter-list/useFilterList.js ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return useFiltersList; });
/* harmony import */ var _vue_composition_api__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @vue/composition-api */ "./node_modules/@vue/composition-api/dist/vue-composition-api.mjs");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/store */ "./resources/js/src/store/index.js");
/* harmony import */ var _core_utils_filter__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @core/utils/filter */ "./resources/js/src/@core/utils/filter.js");
/* harmony import */ var vue_toastification_composition__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-toastification/composition */ "./node_modules/vue-toastification/composition/index.js");
/* harmony import */ var vue_toastification_composition__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(vue_toastification_composition__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _core_components_toastification_ToastificationContent_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @core/components/toastification/ToastificationContent.vue */ "./resources/js/src/@core/components/toastification/ToastificationContent.vue");


 // Notification



function useFiltersList() {
  // Use toast
  var toast = Object(vue_toastification_composition__WEBPACK_IMPORTED_MODULE_3__["useToast"])();
  var refFilterListTable = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null); // Table Handlers

  var tableColumns = [{
    key: 'filter_type',
    sortable: true
  }, {
    key: 'conditions',
    sortable: true
  }, {
    key: 'status',
    sortable: true
  }, {
    key: 'actions'
  }];
  var perPage = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(10);
  var totalFilters = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(0);
  var currentPage = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(1);
  var perPageOptions = [10, 25, 50, 100];
  var searchQuery = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])('');
  var sortBy = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])('id');
  var isSortDirDesc = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(true);
  var roleFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var planFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var statusFilter = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["ref"])(null);
  var dataMeta = Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["computed"])(function () {
    var localItemsCount = refFilterListTable.value ? refFilterListTable.value.localItems.length : 0;
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalFilters.value
    };
  });

  var refetchData = function refetchData() {
    refFilterListTable.value.refresh();
  };

  Object(_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__["watch"])([perPage, currentPage, searchQuery, roleFilter, planFilter, statusFilter], function () {
    refetchData();
  });

  var fetchFilters = function fetchFilters(ctx, callback) {
    _store__WEBPACK_IMPORTED_MODULE_1__["default"].dispatch('app-filters/fetchFilterList', {
      id: router.currentRoute.params.id
    }).then(function (response) {
      var _response$data = response.data,
          filters = _response$data.filters,
          total = _response$data.total;
      callback(filters);
      totalFilters.value = total;
    })["catch"](function () {
      toast({
        component: _core_components_toastification_ToastificationContent_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
        props: {
          title: 'Error fetching Filters list',
          icon: 'AlertTriangleIcon',
          variant: 'danger'
        }
      });
    });
  }; // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*


  var resolveFilterRoleVariant = function resolveFilterRoleVariant(role) {
    if (role === 'subscriber') return 'primary';
    if (role === 'author') return 'warning';
    if (role === 'maintainer') return 'success';
    if (role === 'editor') return 'info';
    if (role === 'admin') return 'danger';
    return 'primary';
  };

  var filterTypeOptions = [{
    label: 'EmploymentStatus',
    value: 'EmploymentStatus'
  }, {
    label: 'Email',
    value: 'Email'
  }, {
    label: 'DateOfBirth',
    value: 'DateOfBirth'
  }, // { label: 'FollowingPayDate', value: 'FollowingPayDate' },
  // { label: 'NextPayDate', value: 'NextPayDate' },
  {
    label: 'IncomeCycle',
    value: 'IncomeCycle'
  }, {
    label: 'LoanAmount',
    value: 'LoanAmount'
  }, {
    label: 'LoanTerms',
    value: 'LoanTerms'
  }, {
    label: 'MaritalStatus',
    value: 'MaritalStatus'
  }, {
    label: 'MonthlyCredit',
    value: 'MonthlyCredit'
  }, {
    label: 'MonthlyIncome',
    value: 'MonthlyIncome'
  }, {
    label: 'Monthly Mortgage/Rent',
    value: 'MonthlyRent'
  }, {
    label: 'MonthsAtAddress',
    value: 'MonthsAtAddress'
  }, {
    label: 'ResidentialStatus',
    value: 'ResidentialStatus'
  }, {
    label: 'InMilitary',
    value: 'InMilitary'
  }, {
    label: 'State',
    value: 'State'
  }, {
    label: 'BankAccountType',
    value: 'BankAccountType'
  }, {
    label: 'Phone',
    value: 'Phone'
  }];
  var tierOptions = [{
    label: 'Tier 1 ABC',
    value: 1
  }];
  var buyerOptions = [{
    label: 'Buyer 1 ABC',
    value: 1
  }];
  var conversionTypeOptions = [{
    label: 'CPA',
    value: 1
  }, {
    label: 'CPF',
    value: 2
  }, {
    label: 'CPL',
    value: 3
  }];
  var statusOptions = [{
    label: 'Active',
    value: 1
  }, {
    label: 'Inactive',
    value: 2
  }];
  var employmentOptions = [{
    text: 'EmployedFullTime',
    value: 'EmployedFullTime'
  }, {
    text: 'EmployedPartTime',
    value: 'EmployedPartTime'
  }, {
    text: 'EmployedTemporary',
    value: 'EmployedTemporary'
  }, {
    text: 'SelfEmployed',
    value: 'SelfEmployed'
  }];
  var incomeCycleOptions = [{
    text: 'SpecificDayOfMonth',
    value: 'SpecificDayOfMonth'
  }, {
    text: 'Weekly',
    value: 'Weekly'
  }, {
    text: 'BiWeekly',
    value: 'BiWeekly'
  }, {
    text: 'Fortnightly',
    value: 'Fortnightly'
  }, {
    text: 'LastDayMonth',
    value: 'LastDayMonth'
  }, {
    text: 'LastWorkingDayMonth',
    value: 'LastWorkingDayMonth'
  }, {
    text: 'TwiceMonthly',
    value: 'TwiceMonthly'
  }, {
    text: 'FourWeekly',
    value: 'FourWeekly'
  }, {
    text: 'LastFriday',
    value: 'LastFriday'
  }, {
    text: 'LastThursday',
    value: 'LastThursday'
  }, {
    text: 'LastWednesday',
    value: 'LastWednesday'
  }, {
    text: 'LastTuesday',
    value: 'LastTuesday'
  }, {
    text: 'LastMonday',
    value: 'LastMonday'
  }];
  var maritalStatusOptions = [{
    text: 'Single',
    value: 'Single'
  }, {
    text: 'Married',
    value: 'Married'
  }, {
    text: 'Divorced',
    value: 'Divorced'
  }, {
    text: 'Widowed',
    value: 'Widowed'
  }, {
    text: 'Other',
    value: 'Other'
  }];
  var residentialStatusOptions = [{
    text: 'HomeOwner',
    value: 'HomeOwner'
  }, {
    text: 'PrivateTenant',
    value: 'PrivateTenant'
  }, {
    text: 'CouncilTenant',
    value: 'CouncilTenant'
  }, {
    text: 'LivingWithParents',
    value: 'LivingWithParents'
  }, {
    text: 'LivingWithFriends',
    value: 'LivingWithFriends'
  }, {
    text: 'Other',
    value: 'Other'
  }];
  var inMilitaryOptions = [{
    text: 'None',
    value: 1
  }, {
    text: 'Veteran',
    value: 2
  }, {
    text: 'Reserves',
    value: 3
  }, {
    text: 'Active Duty',
    value: 4
  }];
  var bankAccountTypeOptions = [{
    text: 'Checking',
    value: 'Checking'
  }, {
    text: 'Savings',
    value: 'Savings'
  }];
  var phoneOptions = [{
    text: 'homePhoneNumber',
    value: 'homePhoneNumber'
  }, {
    text: 'cellPhoneNumber',
    value: 'cellPhoneNumber'
  }, {
    text: 'mobilePhoneNumber',
    value: 'mobilePhoneNumber'
  }, {
    text: 'workPhoneNumber',
    value: 'workPhoneNumber'
  }];
  var stateOptions = [{
    text: 'Alabama',
    value: 'AL'
  }, {
    text: 'Alaska',
    value: 'AK'
  }, {
    text: 'Arizona',
    value: 'AZ'
  }, {
    text: 'Arkansas',
    value: 'AR'
  }, {
    text: 'California',
    value: 'CA'
  }, {
    text: 'Colorado',
    value: 'CO'
  }, {
    text: 'Connecticut',
    value: 'CT'
  }, {
    text: 'Delaware',
    value: 'DE'
  }, {
    text: 'District Of Columbia',
    value: 'DC'
  }, {
    text: 'Florida',
    value: 'FL'
  }, {
    text: 'Georgia',
    value: 'GA'
  }, {
    text: 'Hawaii',
    value: 'HI'
  }, {
    text: 'Idaho',
    value: 'ID'
  }, {
    text: 'Illinois',
    value: 'IL'
  }, {
    text: 'Indiana',
    value: 'IN'
  }, {
    text: 'Iowa',
    value: 'IA'
  }, {
    text: 'Kansas',
    value: 'KS'
  }, {
    text: 'Kentucky',
    value: 'KY'
  }, {
    text: 'Louisiana',
    value: 'LA'
  }, {
    text: 'Maine',
    value: 'ME'
  }, {
    text: 'Maryland',
    value: 'MD'
  }, {
    text: 'Massachusetts',
    value: 'MA'
  }, {
    text: 'Michigan',
    value: 'MI'
  }, {
    text: 'Minnesota',
    value: 'MN'
  }, {
    text: 'Mississippi',
    value: 'MS'
  }, {
    text: 'Missouri',
    value: 'MO'
  }, {
    text: 'Montana',
    value: 'MT'
  }, {
    text: 'Nebraska',
    value: 'NE'
  }, {
    text: 'Nevada',
    value: 'NV'
  }, {
    text: 'New Hampshire',
    value: 'NH'
  }, {
    text: 'New Jersey',
    value: 'NJ'
  }, {
    text: 'New Mexico',
    value: 'NM'
  }, {
    text: 'New York',
    value: 'NY'
  }, {
    text: 'North Carolina',
    value: 'NC'
  }, {
    text: 'North Dakota',
    value: 'ND'
  }, {
    text: 'Ohio',
    value: 'OH'
  }, {
    text: 'Oklahoma',
    value: 'OK'
  }, {
    text: 'Oregon',
    value: 'OR'
  }, {
    text: 'Pennsylvania',
    value: 'PA'
  }, {
    text: 'Rhode Island',
    value: 'RI'
  }, {
    text: 'South Carolina',
    value: 'SC'
  }, {
    text: 'South Dakota',
    value: 'SD'
  }, {
    text: 'Tennessee',
    value: 'TN'
  }, {
    text: 'Texas',
    value: 'TX'
  }, {
    text: 'Utah',
    value: 'UT'
  }, {
    text: 'Vermont',
    value: 'VT'
  }, {
    text: 'Virginia',
    value: 'VA'
  }, {
    text: 'Washington',
    value: 'WA'
  }, {
    text: 'West Virginia',
    value: 'WV'
  }, {
    text: 'Wisconsin',
    value: 'WI'
  }, {
    text: 'Wyoming',
    value: 'WY'
  }];

  var resolveFilterRoleIcon = function resolveFilterRoleIcon(role) {
    if (role === 'subscriber') return 'FilterIcon';
    if (role === 'author') return 'SettingsIcon';
    if (role === 'maintainer') return 'DatabaseIcon';
    if (role === 'editor') return 'Edit2Icon';
    if (role === 'admin') return 'ServerIcon';
    return 'FilterIcon';
  };

  var resolveFilterStatusVariant = function resolveFilterStatusVariant(status) {
    if (status === 3) return 'warning';
    if (status === 1) return 'success';
    if (status === 2) return 'secondary';
    return 'primary';
  };

  function goBack() {
    history.back();
  }

  return {
    fetchFilters: fetchFilters,
    tableColumns: tableColumns,
    perPage: perPage,
    currentPage: currentPage,
    totalFilters: totalFilters,
    dataMeta: dataMeta,
    perPageOptions: perPageOptions,
    searchQuery: searchQuery,
    sortBy: sortBy,
    isSortDirDesc: isSortDirDesc,
    refFilterListTable: refFilterListTable,
    resolveFilterRoleVariant: resolveFilterRoleVariant,
    resolveFilterRoleIcon: resolveFilterRoleIcon,
    resolveFilterStatusVariant: resolveFilterStatusVariant,
    refetchData: refetchData,
    // Extra Filters
    roleFilter: roleFilter,
    planFilter: planFilter,
    statusFilter: statusFilter,
    filterTypeOptions: filterTypeOptions,
    tierOptions: tierOptions,
    conversionTypeOptions: conversionTypeOptions,
    statusOptions: statusOptions,
    buyerOptions: buyerOptions,
    employmentOptions: employmentOptions,
    incomeCycleOptions: incomeCycleOptions,
    maritalStatusOptions: maritalStatusOptions,
    residentialStatusOptions: residentialStatusOptions,
    bankAccountTypeOptions: bankAccountTypeOptions,
    stateOptions: stateOptions,
    phoneOptions: phoneOptions,
    inMilitaryOptions: inMilitaryOptions,
    goBack: goBack
  };
}

/***/ }),

/***/ "./resources/js/src/views/apps/filter/filterStoreModule.js":
/*!*****************************************************************!*\
  !*** ./resources/js/src/views/apps/filter/filterStoreModule.js ***!
  \*****************************************************************/
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
    fetchFilters: function fetchFilters(ctx, queryParams) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get('/admin/buyer-filters', {
          params: queryParams
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchSelectOptions: function fetchSelectOptions(ctx, queryParams) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get('/admin/buyer-filters/fetchSelectOptions', {
          params: queryParams
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchFilter: function fetchFilter(ctx, _ref) {
      var id = _ref.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("/admin/buyer-filters/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchIndividualFilter: function fetchIndividualFilter(ctx, _ref2) {
      var id = _ref2.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("/admin/buyer-filters/fetchIndividualFilter/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    fetchFilterList: function fetchFilterList(ctx, _ref3) {
      var id = _ref3.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("/admin/buyer-filters/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    deleteFilter: function deleteFilter(ctx, _ref4) {
      var id = _ref4.id;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"]["delete"]("/admin/buyer-filters/".concat(id)).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    addFilter: function addFilter(ctx, filterData) {
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].post('/admin/buyer-filters', {
          filter: filterData
        }).then(function (response) {
          return resolve(response);
        })["catch"](function (error) {
          return reject(error);
        });
      });
    },
    updateFilter: function updateFilter(_ref5, filterData) {
      var commit = _ref5.commit;
      return new Promise(function (resolve, reject) {
        _axios__WEBPACK_IMPORTED_MODULE_1__["default"].patch("/admin/buyer-filters/".concat(filterData.id), filterData).then(function (response) {
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