import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import home from '@/components/home'
import layout from '@/components/01Layout'
import badge from '@/components/02badge'
import button from '@/components/03button'
import icon from '@/components/04icon'
import cell from '@/components/05cell'
import circle from '@/components/06circle'
import collapse from '@/components/07collapse'
import list from '@/components/08list'
import lazyload from '@/components/09lazyload'
import navbar from '@/components/10navbar'
import pagination from '@/components/11pagination'
import popup from '@/components/12popup'
import progress from '@/components/13progress'
import rate from '@/components/14rate'
import silder from '@/components/15silder'
import stepper from '@/components/16stepper'
import steps from '@/components/17steps'
import swipe from '@/components/18swipe'
import tab from '@/components/19tab'
import tabbar from '@/components/20tabbar'
import tag from '@/components/21tag'
import checkbox from '@/components/22checkbox'
import field from '@/components/23field'
import numkey from '@/components/24numkey'
import password from '@/components/25password'
import radio from '@/components/26radio'
import search from '@/components/27search'
import switch1 from '@/components/28switch'
import upload from '@/components/29upload'
import actionsheet from '@/components/30Actionsheet'
import dialog from '@/components/31dialog'
import picker from '@/components/32picker'
import picker2 from '@/components/33picker2'
import PullRefresh from '@/components/34PullRefresh'
import toast from '@/components/35toast' 
import SwitchCell from '@/components/36SwitchCell' 
import TreeSelect from '@/components/37TreeSelect' 
import addresslist from '@/components/38addresslist'
import card from '@/components/39card'
import contant from '@/components/40contant'
import goodsaction from '@/components/41goodsaction'
import submitbar from '@/components/42submitbar'
import coupon from '@/components/43coupon'
import area from '@/components/44area'
import addressedit from '@/components/45addressedit'
Vue.use(Router)

export default new Router({
	
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/HelloWorld',
      name: 'HelloWorld',
      component: HelloWorld
    },
     {
      path: '/layout',
      name: 'layout',
      component: layout
    },
     {
      path: '/badge',
      name: 'badge',
      component: badge
    },
    {
      path: '/button',
      name: 'button',
      component: button
    },
    {
      path: '/icon',
      name: 'icon',
      component: icon
    },
     {
      path: '/cell',
      name: 'cell',
      component: cell
    },
     {
      path: '/circle',
      name: 'circle',
      component: circle
    },
    {
      path: '/collapse',
      name: 'collapse',
      component: collapse
    },
    {
      path: '/list',
      name: 'list',
      component: list
    },
    {
      path: '/lazyload',
      name: 'lazyload',
      component: lazyload
    },
    {
      path: '/navbar',
      name: 'navbar',
      component: navbar
    },
     {
      path: '/pagination',
      name: 'pagination',
      component: pagination
    },
     {
      path: '/popup',
      name: 'popup',
      component: popup
    },
    {
      path: '/progress',
      name: 'progress',
      component: progress
    },
    {
      path: '/rate',
      name: 'rate',
      component: rate
    },
     {
      path: '/silder',
      name: 'silder',
      component: silder
    },
    {
      path: '/stepper',
      name: 'stepper',
      component: stepper
    },
    {
      path: '/steps',
      name: 'steps',
      component: steps
    },
     {
      path: '/swipe',
      name: 'swipe',
      component: swipe
    },
    {
      path: '/tab',
      name: 'tab',
      component: tab
    },
     {
      path: '/tabbar',
      name: 'tabbar',
      component: tabbar
    },
    {
      path: '/tag',
      name: 'tag',
      component: tag
    },
     {
      path: '/checkbox',
      name: 'checkbox',
      component: checkbox
    },
     {
      path: '/field',
      name: 'field',
      component: field
    },
    {
      path: '/numkey',
      name: 'numkey',
      component: numkey
    },
    {
      path: '/password',
      name: 'password',
      component: password
    },
     {
      path: '/radio',
      name: 'radio',
      component: radio
    },
    {
      path: '/search',
      name: 'search',
      component: search
    },
     {
      path: '/switch',
      name: 'switch1',
      component: switch1
    },
    {
      path: '/upload',
      name: 'upload',
      component: upload
    },
    {
      path: '/actionsheet',
      name: 'actionsheet',
      component: actionsheet
    },
     {
      path: '/dialog',
      name: 'dialog',
      component: dialog
    },
    {
      path: '/picker',
      name: 'picker',
      component: picker
    },
    {
      path: '/picker2',
      name: 'picker2',
      component: picker2
    },
     {
      path: '/PullRefresh',
      name: 'PullRefresh',
      component: PullRefresh
    },
     {
      path: '/toast',
      name: 'toast',
      component: toast
    },
    {
      path: '/SwitchCell',
      name: 'SwitchCell',
      component: SwitchCell
    },
    {
      path: '/TreeSelect',
      name: 'TreeSelect',
      component: TreeSelect
    },
     {
      path: '/addresslist',
      name: 'addresslist',
      component: addresslist
    },
    {
      path: '/card',
      name: 'card',
      component: card
    },
     {
      path: '/contant',
      name: 'contant',
      component: contant
    },
     {
      path: '/goodsaction',
      name: 'goodsaction',
      component: goodsaction
    },
     {
      path: '/submitbar',
      name: 'submitbar',
      component: submitbar
    },
    {
      path: '/coupon',
      name: 'coupon',
      component: coupon
    },
    {
      path: '/area',
      name: 'area',
      component: area
    },
    {
      path: '/addressedit',
      name: 'addressedit',
      component: addressedit
    },
  ]
})
