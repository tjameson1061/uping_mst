import {ref, watch, computed} from '@vue/composition-api'
import store from '@/store'
import {title} from '@core/utils/filter'

// Notification
import {useToast} from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {getUserData} from '@/auth/utils'

export default function useReportsList() {
    // Use toast
    const toast = useToast()

    const refReportListTable = ref(null)

    // Table Handlers
    const tableColumns = [
        {key: 'vid', label: 'AFF ID', sortable: true},
        {key: 'subid', label: 'SUB ID', sortable: true},
        {key: 'buyerTierID', label: 'Buyer ID', sortable: true},
        {key: 'vidLeadPrice', label: 'Price', sortable: true},
        {key: 'quality_score', label: 'Lead Quality', sortable: true},
        {key: 'isRedirected', label: 'Redirect', sortable: true},
        {key: 'leadStatus', label: 'status', sortable: true},
        {key: 'actions'},
    ]
    const perPage = ref(10)
    const totalReports = ref(0)
    const currentPage = ref(1)
    const perPageOptions = [10, 25, 50, 100]
    const searchQuery = ref('')
    const sortBy = ref('id')
    const isSortDirDesc = ref(true)
    const subIdFilter = ref(null)
    const tierFilter = ref(null)
    const vidLeadPriceFilter = ref(null)
    const redirectionFilter = ref(null)
    const statusFilter = ref(null)

    const dataMeta = computed(() => {
        const localItemsCount = refReportListTable.value ? refReportListTable.value.localItems.length : 0
        return {
            from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalReports.value,
        }
    })

    const refetchData = () => {
        refReportListTable.value.refresh()
    }

    watch([
        currentPage,
        perPage,
        searchQuery,

        subIdFilter,
        tierFilter,
        vidLeadPriceFilter,
        redirectionFilter,
        statusFilter,
    ], () => {
        refetchData()
    })

    const userData = getUserData()
    const fetchReports = (ctx, callback) => {
        store
            .dispatch('app-report/fetchReports', {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,

                subId: subIdFilter.value,
                tier: tierFilter.value,
                vidLeadPrice: vidLeadPriceFilter.value,
                redirection: redirectionFilter.value,
                status: statusFilter.value,
            })

            .then(response => {
                const { reports } = response.data;
                callback(reports.data);
                totalReports.value = reports.total;
            })
            .catch((err) => {
                console.log(err)
                toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Error fetching report list',
                        icon: 'AlertTriangleIcon',
                        variant: 'danger',
                    },
                })
            })
    }


    // *===============================================---*
    // *--------- UI ---------------------------------------*
    // *===============================================---*

    const resolveReportRoleVariant = role => {
        if (role === 'subscriber') return 'primary'
        if (role === 'author') return 'warning'
        if (role === 'maintainer') return 'success'
        if (role === 'editor') return 'info'
        if (role === 'admin') return 'danger'
        return 'primary'
    }
    const resolveReportRoleIcon = role => {
        if (role === 'subscriber') return 'ReportIcon'
        if (role === 'author') return 'SettingsIcon'
        if (role === 'maintainer') return 'DatabaseIcon'
        if (role === 'editor') return 'Edit2Icon'
        if (role === 'admin') return 'ServerIcon'
        return 'ReportIcon'
    }
    const resolveReportStatusVariant = status => {
        if (status === 'declined') return 'danger'
        if (status === 'sold') return 'success'
        if (status === 'cpf') return 'warning'
        return 'primary'
    }

    const statusOptions = [
        { label: 'Sold', value: 1 },
        { label: 'Pending', value: 3 },
        { label: 'Declined', value: 2 },
    ]
    const redirectionOptions = [
        { label: '100%', value: 1 },
        { label: '0%', value: 0 },
    ]

    return {
        fetchReports,
        tableColumns,
        perPage,
        currentPage,
        totalReports,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refReportListTable,

        resolveReportRoleVariant,
        resolveReportRoleIcon,
        resolveReportStatusVariant,
        refetchData,

        // Extra Filters
        subIdFilter,
        tierFilter,
        vidLeadPriceFilter,
        statusFilter,
        redirectionFilter,

        // Filter Options
        statusOptions,
        redirectionOptions,
    }
}
