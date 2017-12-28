<template>
	<div class='search-container'
		 ref="input"
		 v-bind:value="value"
	>
		<input 
			type="text" 
			name='search_text' 
			placeholder="Search for shit here..."
			v-model="searchText"
			v-on:input="search"
		>
		<div class="search-results"
			 v-if='securities'
		>
			<div class="search-result"
				 v-for="security in securities"
				 v-html='highlightSearch(security.symbol + " - " + security.name, searchText)'
				 v-on:click="select(security)"
			>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data: function () {
			return {
				searchText: '',
				securities: false
			}
		},
		props: [
            'value'
        ],
		methods: {
			search: function () {
			    let self = this;
                axios.get('/security/search', {
                    params: {
                        search_text: this.searchText
                    }
                })
				.then(function (response) {
					const securities = response.data;
					self.securities = securities
				});
            },
            highlightSearch: function (value, searchText) {
                if (!value) return '';
                const regexp = new RegExp(searchText, "gi");
                value = value.replace(regexp, function (x) {
                    return '<b>' + x + '</b>';
                });
                return value
            },
			select: function (security) {
				this.searchText = security.symbol + ' - ' + security.name;
				this.securities = false;
			    this.$refs.input.value = security.id;
			    this.$emit('input', security.id);
			}
		},
        filters: {

        }
	}
</script>