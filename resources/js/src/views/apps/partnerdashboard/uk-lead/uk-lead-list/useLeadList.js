import { ref, watch, computed } from "@vue/composition-api";
import store from "@/store";
import { title } from "@core/utils/filter";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default function useLeadList() {
    // Use toast
    const toast = useToast();

    const refUKLeadsListTable = ref(null);

    // Table Handlers
    const tableColumns = [
        { key: "id", label: "ID", sortable: true },
        { key: "info",  icon: 'TrendingUp', sortable: true },
        { key: "vid", label: "AFF ID", sortable: true },
        { key: "subid", label: "SUB ID", sortable: true },
        { key: "buyerTierID", label: "Buyer ID", sortable: true },
        { key: "vidLeadPrice", label: "Lead Price", sortable: true },
        { key: "leadStatus", label: "Status", sortable: true },
        { key: "isRedirected", label: "Redirection", sortable: true },
        { key: "created_at", label: "Timestamp", sortable: true },
    ];
    const perPage = ref(10);
    const totalUKLeads = ref(0);
    const currentPage = ref(1);
    const perPageOptions = [10, 25, 50, 100];
    const searchQuery = ref("");
    const sortBy = ref("id");
    const isSortDirDesc = ref(true);

    const affiliateFilter = ref(null);
    const subIdFilter = ref(null);
    const tierFilter = ref(null);
    const vendorPriceFilter = ref(null);
    const buyerPriceFilter = ref(null);
    const leadStatusFilter = ref(null);

    const dataMeta = computed(() => {
        const localItemsCount = refUKLeadsListTable.value
            ? refUKLeadsListTable.value.localItems.length
            : 0;
        return {
            from:
                perPage.value * (currentPage.value - 1) +
                (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalUKLeads.value,
        };
    });

    const refetchData = () => {
        refUKLeadsListTable.value.refresh();
    };

    watch(
        [
            currentPage,
            perPage,
            searchQuery,
            leadStatusFilter,
            affiliateFilter,
            subIdFilter,
            tierFilter,
            vendorPriceFilter,
            buyerPriceFilter,
        ],
        () => {
            refetchData();
        }
    );

    const fetchUKLeads = (ctx, callback) => {
        store
            .dispatch("apps-partner-lead-uk/fetchUKLeads", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,

                affiliateFilter: affiliateFilter.value,
                subIdFilter: subIdFilter.value,
                tierFilter: tierFilter.value,
                vendorPriceFilter: vendorPriceFilter.value,
                buyerPriceFilter: buyerPriceFilter.value,
                leadStatusFilter: leadStatusFilter.value,
            })
            .then((response) => {
                const { leads } = response.data;
                callback(leads.data);
                totalUKLeads.value = leads.total;
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error fetching dashboard data",
                        icon: "AlertTriangleIcon",
                        variant: "danger",
                    },
                });
            });
    };

    // *===============================================---*
    // *--------- UI ---------------------------------------*
    // *===============================================---*

    const resolveUKLeadsRoleVariant = (role) => {
        if (role === "subscriber") return "primary";
        if (role === "author") return "warning";
        if (role === "maintainer") return "success";
        if (role === "editor") return "info";
        if (role === "admin") return "danger";
        return "primary";
    };

    const resolveUKLeadsRoleIcon = (role) => {
        if (role === "subscriber") return "UKLeadsIcon";
        if (role === "author") return "SettingsIcon";
        if (role === "maintainer") return "DatabaseIcon";
        if (role === "editor") return "Edit2Icon";
        if (role === "admin") return "ServerIcon";
        return "UKLeadsIcon";
    };

    const resolveUKLeadsStatusVariant = (leadStatus) => {
        if (leadStatus === 2) return "danger";
        if (leadStatus === 1) return "success";
        if (leadStatus === 3) return "secondary";
        return "primary";
    };

    const resolveUKLeadsStatusVariantAndIcon = (leadStatus) => {
        if (leadStatus === 1) return { variant: "success", icon: "CheckCircleIcon" };
        if (leadStatus === 0) return { variant: "warning", icon: "XIcon" };
        if (leadStatus === 2) return { variant: "danger", icon: "UserXIcon" };
        if (leadStatus === 3) return { variant: "secondary", icon: "LoaderIcon" };
        return { variant: "secondary", icon: "XIcon" };
    };

    return {
        fetchUKLeads,
        tableColumns,
        perPage,
        currentPage,
        totalUKLeads,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refUKLeadsListTable,

        resolveUKLeadsRoleVariant,
        resolveUKLeadsRoleIcon,
        resolveUKLeadsStatusVariant,
        resolveUKLeadsStatusVariantAndIcon,
        refetchData,

        // Extra Filters
        leadStatusFilter,
        affiliateFilter,
        subIdFilter,
        tierFilter,
        vendorPriceFilter,
        buyerPriceFilter,
    };
}
