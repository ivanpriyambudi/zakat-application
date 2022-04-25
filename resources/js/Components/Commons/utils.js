import { parse } from 'qs'
import {Inertia} from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import _ from 'lodash'

function getQueryParams(search) {
  return parse(search, {
    ignoreQueryPrefix: true,
    arrayFormat: 'brackets',
    skipNulls: true,
  })
}

function getUrl() {
  const array = usePage().url.value.split('?')
  return array[0]
}

function toFilter(currentQuery, value, key, keyNull = false) {
  const newQuery = new Object()
  newQuery.filter = new Object()
  
  if (currentQuery.filter !== undefined) {
    newQuery.filter = currentQuery.filter
  }

  newQuery.filter[key] = value

  if (keyNull) {
    newQuery.filter[keyNull] = null
  }

  return Inertia.get(getUrl(), { ...newQuery, page: 1}, { replace: true })
}

function getFilter(applyFilter, key, integer = false) {
  const value = integer ? parseInt(_.get(applyFilter, key)) : _.get(applyFilter, key)
  return _.get(applyFilter, key) ? value : ''
}

function toSearch() {

}

export {
  getQueryParams,
  toFilter,
  getFilter,
  getUrl,
  toSearch,
}