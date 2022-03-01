<script type="text/x-template" id="tree-template">
    <ul>
        <li v-for="v in children" :class="(v.name=='{{isset($active)?$active:''}}'?'mm-active':'')">
            <a v-if="v.is_route==1" :href="v.route" class="menu_list" :param_name="v.name">
                <div class="parent-icon icon-color-9"><i :class="v.ico"></i></div>
                <div class="menu-title">@{{v.full_name}}</div>
            </a>
            <a v-else class="has-arrow" href="javascript:void(0);">
                <div class="parent-icon icon-color-10"><i :class="v.ico"></i>
                </div>
                <div class="menu-title">@{{v.full_name}}</div>
            </a>
            <tree :children="v.children"></tree>
        </li>
    </ul>
</script>

<script>
    Vue.component('tree', {
        props: ['children'],
        data: function () {
            return{
            }
        },
        template: '#tree-template',
        methods:{

        },
    })
</script>