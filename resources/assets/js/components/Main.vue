<template>
	<div class='main-container'>
		<security-search
			v-model='securitySearch'
			v-on:input="selected"
		>
		</security-search>
		<history-graph
			v-if="currentSecurity"
			v-bind:security="currentSecurity"
		>
		</history-graph>
	</div>
</template>

<script>
	import SecuritySearch from './security/Search.vue'
    import HistoryGraph from './security/HistoryGraph.vue'

	export default {
	    data: function () {
	      	return {
				securitySearch: '',
				currentSecurity: false
			};
		},
		mounted: function () {
	        //this.selected(1);
		},
		components: {
			SecuritySearch,
            HistoryGraph
		},
		methods: {
		    selected: function (security_id) {
		        let self = this;
                axios.get('/security/' + security_id)
				.then(function (response) {
					self.currentSecurity = response.data;
				});
			}
		}
	}
</script>