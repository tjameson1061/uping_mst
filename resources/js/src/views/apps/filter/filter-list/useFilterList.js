import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useFiltersList() {
    // Use toast
    const toast = useToast()

    const refFilterListTable = ref(null)

    // Table Handlers
    const tableColumns = [
        { key: 'filter_type', sortable: true },
        { key: 'conditions', sortable: true },
        { key: 'status', sortable: true },
        { key: 'actions' },
    ]

    const perPage = ref(10)
    const totalFilters = ref(0)
    const currentPage = ref(1)
    const perPageOptions = [10, 25, 50, 100]
    const searchQuery = ref('')
    const sortBy = ref('id')
    const isSortDirDesc = ref(true)
    const roleFilter = ref(null)
    const planFilter = ref(null)
    const statusFilter = ref(null)

    const dataMeta = computed(() => {
        const localItemsCount = refFilterListTable.value ? refFilterListTable.value.localItems.length : 0
        return {
            from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalFilters.value,
        }
    })

    const refetchData = () => {
        refFilterListTable.value.refresh()
    }

    watch([
        perPage,
        currentPage,
        searchQuery,
        roleFilter,
        planFilter,
        statusFilter
    ], () => {
        refetchData()
    })

    const fetchFilters = (ctx, callback) => {
        store
            .dispatch('app-filters/fetchFilterList', { id: router.currentRoute.params.id })
            .then(response => {
                const { filters, total } = response.data

                callback(filters)
                totalFilters.value = total
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Error fetching Filters list',
                        icon: 'AlertTriangleIcon',
                        variant: 'danger',
                    },
                })
            })
    }

    // *===============================================---*
    // *--------- UI ---------------------------------------*
    // *===============================================---*

    const resolveFilterRoleVariant = role => {
        if (role === 'subscriber') return 'primary'
        if (role === 'author') return 'warning'
        if (role === 'maintainer') return 'success'
        if (role === 'editor') return 'info'
        if (role === 'admin') return 'danger'
        return 'primary'
    }

    const filterTypeOptions = [
        { label: 'EmploymentStatus', value: 'EmploymentStatus' },
        { label: 'Email', value: 'Email' },
        { label: 'DateOfBirth', value: 'DateOfBirth' },
        // { label: 'FollowingPayDate', value: 'FollowingPayDate' },
        // { label: 'NextPayDate', value: 'NextPayDate' },
        { label: 'IncomeCycle', value: 'IncomeCycle' },
        { label: 'LoanAmount', value: 'LoanAmount' },
        { label: 'LoanTerms', value: 'LoanTerms' },
        { label: 'MaritalStatus', value: 'MaritalStatus' },
        { label: 'MonthlyCredit', value: 'MonthlyCredit' },
        { label: 'MonthlyIncome', value: 'MonthlyIncome' },
        { label: 'Monthly Mortgage/Rent', value: 'MonthlyRent' },
        { label: 'MonthsAtAddress', value: 'MonthsAtAddress' },
        { label: 'ResidentialStatus', value: 'ResidentialStatus' },
        { label: 'InMilitary', value: 'InMilitary' },
        { label: 'State', value: 'State' },
        { label: 'BankAccountType', value: 'BankAccountType' },
        { label: 'Phone', value: 'Phone' },
    ]
    const tierOptions = [
        { label: 'Tier 1 ABC', value: 1 },
    ]
    const buyerOptions = [
        { label: 'Buyer 1 ABC', value: 1 },
    ]
    const conversionTypeOptions = [
        { label: 'CPA', value: 1 },
        { label: 'CPF', value: 2 },
        { label: 'CPL', value: 3 },
    ]
    const statusOptions = [
        { label: 'Active', value: 1 },
        { label: 'Inactive', value: 2 },
    ]
    const employmentOptions = [
        { text: 'EmployedFullTime', value: 'EmployedFullTime' },
        { text: 'EmployedPartTime', value: 'EmployedPartTime' },
        { text: 'EmployedTemporary', value: 'EmployedTemporary' },
        { text: 'SelfEmployed', value: 'SelfEmployed' },
    ]
    const incomeCycleOptions = [
        { text: 'SpecificDayOfMonth', value: 'SpecificDayOfMonth' },
        { text: 'Weekly', value: 'Weekly' },
        { text: 'BiWeekly', value: 'BiWeekly' },
        { text: 'Fortnightly', value: 'Fortnightly' },
        { text: 'LastDayMonth', value: 'LastDayMonth' },
        { text: 'LastWorkingDayMonth', value: 'LastWorkingDayMonth' },
        { text: 'TwiceMonthly', value: 'TwiceMonthly' },
        { text: 'FourWeekly', value: 'FourWeekly' },
        { text: 'LastFriday', value: 'LastFriday' },
        { text: 'LastThursday', value: 'LastThursday' },
        { text: 'LastWednesday', value: 'LastWednesday' },
        { text: 'LastTuesday', value: 'LastTuesday' },
        { text: 'LastMonday', value: 'LastMonday' },
    ]
    const maritalStatusOptions = [
        { text: 'Single', value: 'Single' },
        { text: 'Married', value: 'Married' },
        { text: 'Divorced', value: 'Divorced' },
        { text: 'Widowed', value: 'Widowed' },
        { text: 'Other', value: 'Other' },
    ]

    const residentialStatusOptions = [
        { text: 'HomeOwner', value: 'HomeOwner' },
        { text: 'PrivateTenant', value: 'PrivateTenant' },
        { text: 'CouncilTenant', value: 'CouncilTenant' },
        { text: 'LivingWithParents', value: 'LivingWithParents' },
        { text: 'LivingWithFriends', value: 'LivingWithFriends' },
        { text: 'Other', value: 'Other' },
    ]
    const inMilitaryOptions = [
        { text: 'None', value: 'None' },
        { text: 'Veteran', value: 'Veteran' },
        { text: 'Reserves', value: 'Reserves' },
        { text: 'Active Duty', value: 'Active Duty' },
    ]
    const bankAccountTypeOptions = [
        { text: 'Checking', value: 'Checking' },
        { text: 'Savings', value: 'Savings' },
    ]
    const phoneOptions = [
        { text: 'Home Phone Number', value: 'homePhoneNumber' },
        { text: 'Cell Phone Number', value: 'cellPhoneNumber' },
        { text: 'Mobile Phone Number', value: 'mobilePhoneNumber' },
        { text: 'Work Phone Number', value: 'workPhoneNumber' },
    ]
    const stateOptions = [
        { text: 'Alabama', value: 'AL' },
        { text: 'Alaska', value: 'AK' },
        { text: 'Arizona', value: 'AZ' },
        { text: 'Arkansas', value: 'AR' },
        { text: 'California', value: 'CA' },
        { text: 'Colorado', value: 'CO' },
        { text: 'Connecticut', value: 'CT' },
        { text: 'Delaware', value: 'DE' },
        { text: 'District Of Columbia', value: 'DC' },
        { text: 'Florida', value: 'FL' },
        { text: 'Georgia', value: 'GA' },
        { text: 'Hawaii', value: 'HI' },
        { text: 'Idaho', value: 'ID' },
        { text: 'Illinois', value: 'IL' },
        { text: 'Indiana', value: 'IN' },
        { text: 'Iowa', value: 'IA' },
        { text: 'Kansas', value: 'KS' },
        { text: 'Kentucky', value: 'KY' },
        { text: 'Louisiana', value: 'LA' },
        { text: 'Maine', value: 'ME' },
        { text: 'Maryland', value: 'MD' },
        { text: 'Massachusetts', value: 'MA' },
        { text: 'Michigan', value: 'MI' },
        { text: 'Minnesota', value: 'MN' },
        { text: 'Mississippi', value: 'MS' },
        { text: 'Missouri', value: 'MO' },
        { text: 'Montana', value: 'MT' },
        { text: 'Nebraska', value: 'NE' },
        { text: 'Nevada', value: 'NV' },
        { text: 'New Hampshire', value: 'NH' },
        { text: 'New Jersey', value: 'NJ' },
        { text: 'New Mexico', value: 'NM' },
        { text: 'New York', value: 'NY' },
        { text: 'North Carolina', value: 'NC' },
        { text: 'North Dakota', value: 'ND' },
        { text: 'Ohio', value: 'OH' },
        { text: 'Oklahoma', value: 'OK' },
        { text: 'Oregon', value: 'OR' },
        { text: 'Pennsylvania', value: 'PA' },
        { text: 'Rhode Island', value: 'RI' },
        { text: 'South Carolina', value: 'SC' },
        { text: 'South Dakota', value: 'SD' },
        { text: 'Tennessee', value: 'TN' },
        { text: 'Texas', value: 'TX' },
        { text: 'Utah', value: 'UT' },
        { text: 'Vermont', value: 'VT' },
        { text: 'Virginia', value: 'VA' },
        { text: 'Washington', value: 'WA' },
        { text: 'West Virginia', value: 'WV' },
        { text: 'Wisconsin', value: 'WI' },
        { text: 'Wyoming', value: 'WY' },

    ]


    const resolveFilterRoleIcon = role => {
        if (role === 'subscriber') return 'FilterIcon'
        if (role === 'author') return 'SettingsIcon'
        if (role === 'maintainer') return 'DatabaseIcon'
        if (role === 'editor') return 'Edit2Icon'
        if (role === 'admin') return 'ServerIcon'
        return 'FilterIcon'
    }

    const resolveFilterStatusVariant = status => {
        if (status === 3) return 'warning'
        if (status === 1) return 'success'
        if (status === 2) return 'secondary'
        return 'primary'
    }

    function goBack() {
        history.back()
    }




    return {
        fetchFilters,
        tableColumns,
        perPage,
        currentPage,
        totalFilters,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refFilterListTable,

        resolveFilterRoleVariant,
        resolveFilterRoleIcon,
        resolveFilterStatusVariant,
        refetchData,

        // Extra Filters
        roleFilter,
        planFilter,
        statusFilter,

        filterTypeOptions,
        tierOptions,
        conversionTypeOptions,
        statusOptions,
        buyerOptions,

        employmentOptions,
        incomeCycleOptions,
        maritalStatusOptions,
        residentialStatusOptions,
        bankAccountTypeOptions,
        stateOptions,
        phoneOptions,
        inMilitaryOptions,
        goBack,
    }
}
