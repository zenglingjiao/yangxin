/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : db_sunny_migrations

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 24/12/2021 17:05:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT 1 COMMENT '几級菜單',
  `parent` int(11) NOT NULL DEFAULT 0 COMMENT '父級ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '全稱',
  `is_menu` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否菜單：0=否，1=是',
  `is_route` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否路由：0=否，1=是',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路由',
  `active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路由標識',
  `ico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 1, 0, 'menu_list', 'auth_admin', '菜單管理', 1, 1, 'admin/menu_list', 'menu_list', 'lni lni-list', 0, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (2, 2, 1, 'menu_update', 'auth_admin', '編輯', 0, 1, 'admin/menu_update', '', '', 1, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (3, 2, 1, 'menu_del', 'auth_admin', '刪除', 0, 1, 'admin/menu_del', '', '', 2, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (4, 1, 0, 'index', 'auth_admin', '首頁', 1, 1, 'admin/index', 'index', 'fadeIn animated bx bx-home-alt', 1, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (5, 1, 0, 'amdin_manage', 'auth_admin', '權限管理', 1, 0, '', '', 'lni lni-list', 2, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (6, 2, 5, 'admin_list', 'auth_admin', '管理員管理', 1, 1, 'admin/admin_list', 'admin_list', 'fadeIn animated bx bx-group', 3, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (7, 3, 6, 'admin_edit', 'auth_admin', '編輯', 0, 1, 'admin/admin_edit', '', '', 1, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (8, 3, 6, 'admin_delete', 'auth_admin', '刪除', 0, 1, 'admin/admin_delete', '', '', 2, '2021-12-23 21:16:39', NULL);
INSERT INTO `permissions` VALUES (9, 2, 5, 'role_list', 'auth_admin', '管理員身份', 1, 1, 'admin/role_list', 'role_list', 'fadeIn animated bx bx-user-circle', 4, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (10, 3, 9, 'role_edit', 'auth_admin', '編輯', 0, 1, 'admin/role_edit', '', '', 1, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (11, 3, 9, 'role_delete', 'auth_admin', '刪除', 0, 1, 'admin/role_delete', '', '', 2, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (12, 2, 5, 'group_list', 'auth_admin', '群組管理', 1, 1, 'admin/group_list', 'group_list', 'lni lni-network', 5, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (13, 3, 12, 'group_edit', 'auth_admin', '編輯', 0, 1, 'admin/group_edit', '', '', 1, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (14, 3, 12, 'group_delete', 'auth_admin', '刪除', 0, 1, 'admin/group_delete', '', '', 2, '2021-12-23 21:16:40', NULL);
INSERT INTO `permissions` VALUES (15, 1, 0, 'basic_setting', 'auth_admin', '基礎設定', 1, 0, '', '', 'lni lni-list', 5, '2021-12-21 19:11:11', NULL);
INSERT INTO `permissions` VALUES (16, 2, 15, 'index_setting', 'auth_admin', '首頁設定', 1, 0, '', '', 'bx bx-right-arrow-alt', 6, '2021-12-21 19:11:11', NULL);
INSERT INTO `permissions` VALUES (17, 3, 16, 'pc_app_index_setting', 'auth_admin', 'PC/APP首頁設定', 1, 0, '', '', 'bx bx-right-arrow-alt', 7, '2021-12-21 19:11:11', NULL);
INSERT INTO `permissions` VALUES (18, 4, 17, 'banner_setting', 'auth_admin', 'Banner設定', 1, 0, '', '', 'bx bx-right-arrow-alt', 8, '2021-12-21 19:11:11', NULL);
INSERT INTO `permissions` VALUES (19, 5, 18, 'banner_big_list', 'auth_admin', '大Banner', 1, 1, 'admin/banner/big_list', 'banner_big_list', 'lni lni-image', 9, '2021-12-21 19:11:11', '2021-12-21 19:49:35');
INSERT INTO `permissions` VALUES (20, 6, 19, 'banner_big_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/big_edit', '', '', 1, '2021-12-21 19:11:11', '2021-12-21 19:49:47');
INSERT INTO `permissions` VALUES (21, 6, 19, 'banner_big_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/big_del', '', '', 2, '2021-12-21 19:11:11', '2021-12-21 19:49:58');
INSERT INTO `permissions` VALUES (22, 5, 18, 'banner_below_list', 'auth_admin', 'banner下方', 1, 1, 'admin/banner/below_list', '', '', 0, '2021-12-23 15:30:11', NULL);
INSERT INTO `permissions` VALUES (23, 6, 22, 'banner_below_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/below_edit', '', '', 0, '2021-12-23 15:32:23', NULL);
INSERT INTO `permissions` VALUES (24, 6, 22, 'banner_below_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/below_del', '', '', 0, '2021-12-23 15:33:27', NULL);
INSERT INTO `permissions` VALUES (25, 5, 18, 'banner_middle_list', 'auth_admin', '中間廣告', 1, 1, 'admin/banner/middle_list', '', '', 0, '2021-12-23 15:34:51', NULL);
INSERT INTO `permissions` VALUES (26, 6, 25, 'banner_middle_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/middle_edit', '', '', 0, '2021-12-23 15:36:24', '2021-12-23 15:38:57');
INSERT INTO `permissions` VALUES (27, 6, 25, 'banner_middle_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/middle_del', '', '', 0, '2021-12-23 15:37:08', NULL);
INSERT INTO `permissions` VALUES (28, 5, 18, 'banner_middle_carousel_list', 'auth_admin', '中間輪播廣告', 1, 1, 'admin/banner/middle_carousel_list', '', '', 0, '2021-12-23 15:38:22', NULL);
INSERT INTO `permissions` VALUES (29, 6, 28, 'banner_middle_carousel_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/middle_carousel_edit', '', '', 0, '2021-12-23 15:40:27', NULL);
INSERT INTO `permissions` VALUES (30, 6, 28, 'banner_middle_carousel_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/middle_carousel_del', '', '', 0, '2021-12-23 15:41:25', NULL);
INSERT INTO `permissions` VALUES (31, 5, 18, 'banner_sales_list', 'auth_admin', '促銷廣告', 1, 1, 'admin/banner/sales_list', '', '', 0, '2021-12-23 15:42:59', NULL);
INSERT INTO `permissions` VALUES (32, 6, 31, 'banner_sales_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner_sales_edit', '', '', 0, '2021-12-23 15:43:59', NULL);
INSERT INTO `permissions` VALUES (33, 6, 31, 'banner_sales_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/sales_del', '', '', 0, '2021-12-23 15:45:03', NULL);
INSERT INTO `permissions` VALUES (34, 4, 17, 'annexe_hot_list', 'auth_admin', '熱門館別', 1, 1, 'admin/annexe_hot', '', '', 0, '2021-12-23 15:47:59', NULL);
INSERT INTO `permissions` VALUES (35, 5, 34, 'annexe_hot_edit', 'auth_admin', '編輯', 0, 1, 'admin/annexe_hot_edit', '', '', 0, '2021-12-23 15:49:11', NULL);
INSERT INTO `permissions` VALUES (36, 5, 34, 'annexe_hot_del', 'auth_admin', '刪除', 0, 1, 'admin/annexe_hot_del', '', '', 0, '2021-12-23 15:49:48', NULL);
INSERT INTO `permissions` VALUES (37, 4, 17, 'banner_kayou_index', 'auth_admin', '卡友好康', 1, 1, 'admin/banner/kayou', '', '', 0, '2021-12-23 15:52:40', NULL);
INSERT INTO `permissions` VALUES (38, 5, 37, 'banner_kayou_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/kayou_edit', '', '', 0, '2021-12-23 15:53:38', NULL);
INSERT INTO `permissions` VALUES (39, 5, 37, 'banner_kayou_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/kayou_del', '', '', 0, '2021-12-23 15:54:11', NULL);
INSERT INTO `permissions` VALUES (40, 4, 17, 'banner_member_index', 'auth_admin', '會員專區', 1, 1, 'admin/banner/member', '', '', 0, '2021-12-23 15:55:11', NULL);
INSERT INTO `permissions` VALUES (41, 5, 40, 'banner_member_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/member_edit', '', '', 0, '2021-12-23 15:55:52', NULL);
INSERT INTO `permissions` VALUES (42, 5, 40, 'banner_member_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/member_del', '', '', 0, '2021-12-23 15:59:15', NULL);
INSERT INTO `permissions` VALUES (43, 3, 16, 'pc_home', 'auth_admin', 'PC首頁', 1, 0, '', '', 'lni lni-laptop', 0, '2021-12-23 16:05:14', '2021-12-24 14:21:47');
INSERT INTO `permissions` VALUES (44, 4, 43, 'advertisement_up_index', 'auth_admin', '上方廣告', 1, 1, 'admin/advertisement/up', '', 'lni lni-list', 0, '2021-12-23 16:07:07', NULL);
INSERT INTO `permissions` VALUES (45, 5, 44, 'advertisement_update', 'auth_admin', '編輯', 0, 1, 'admin/advertisement/update', '', '', 0, '2021-12-23 16:08:57', NULL);
INSERT INTO `permissions` VALUES (46, 5, 44, 'advertisement_del', 'auth_admin', '刪除', 0, 1, 'admin/advertisement_del', '', '', 0, '2021-12-23 16:09:32', NULL);
INSERT INTO `permissions` VALUES (47, 4, 43, 'navi_index', 'auth_admin', '上方導航管理', 1, 1, 'admin/navi', '', 'lni lni-list', 0, '2021-12-23 16:10:45', NULL);
INSERT INTO `permissions` VALUES (48, 5, 47, 'navi_update', 'auth_admin', '編輯', 0, 1, 'admin/navi/update', '', '', 0, '2021-12-23 16:12:23', NULL);
INSERT INTO `permissions` VALUES (49, 5, 47, 'navi_del', 'auth_admin', '刪除', 0, 1, 'admin/navi/del', '', '', 0, '2021-12-23 16:13:26', NULL);
INSERT INTO `permissions` VALUES (50, 4, 43, 'season_recommend_index', 'auth_admin', '強檔推薦', 1, 1, 'admin/brand/recommend', '', 'lni lni-list', 0, '2021-12-23 16:15:06', NULL);
INSERT INTO `permissions` VALUES (51, 5, 50, 'season_recommend_update', 'auth_admin', '編輯', 0, 1, 'admin/season_recommend/update', '', '', 0, '2021-12-23 16:15:43', NULL);
INSERT INTO `permissions` VALUES (52, 5, 50, 'season_recommend_del', 'auth_admin', '刪除', 0, 1, 'admin/season_recommend/del', '', '', 0, '2021-12-23 16:16:14', NULL);
INSERT INTO `permissions` VALUES (53, 4, 43, 'choiceness_index', 'auth_admin', '精選專區', 1, 1, 'admin/choiceness', '', 'lni lni-list', 0, '2021-12-23 16:17:22', NULL);
INSERT INTO `permissions` VALUES (54, 5, 53, 'choiceness_edit', 'auth_admin', '編輯', 0, 1, 'admin/choiceness/edit', '', '', 0, '2021-12-23 16:20:16', NULL);
INSERT INTO `permissions` VALUES (55, 5, 53, 'choiceness_del', 'auth_admin', '刪除', 0, 1, 'admin/choiceness/del', '', '', 0, '2021-12-23 16:20:56', NULL);
INSERT INTO `permissions` VALUES (56, 4, 43, 'advertisement_down_index', 'auth_admin', '下方廣告', 1, 1, 'admin/advertisement/down', '', 'lni lni-list', 0, '2021-12-23 16:21:49', NULL);
INSERT INTO `permissions` VALUES (57, 3, 16, 'phone_home', 'auth', '手機首頁', 1, 0, '', '', 'lni lni-mobile', 0, '2021-12-23 16:22:40', '2021-12-23 17:51:41');
INSERT INTO `permissions` VALUES (58, 4, 57, 'banner_middle_activity_index', 'auth_admin', '中間活動', 1, 1, 'admin/banner/middle_activity', '', 'lni lni-list', 0, '2021-12-23 16:23:49', NULL);
INSERT INTO `permissions` VALUES (59, 5, 58, 'banner_middle_activity_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/middle_activity_update', '', '', 0, '2021-12-23 16:24:46', NULL);
INSERT INTO `permissions` VALUES (60, 5, 58, 'banner_middle_activity_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/middle_activity_del', '', '', 0, '2021-12-23 16:25:26', NULL);
INSERT INTO `permissions` VALUES (61, 4, 57, 'brand_recommend_index', 'auth_admin', '推薦品牌', 1, 1, 'admin/brand_recommend', '', 'lni lni-list', 0, '2021-12-23 16:26:37', NULL);
INSERT INTO `permissions` VALUES (62, 5, 61, 'brand_recommend_update', 'auth_admin', '編輯', 0, 1, 'admin/brand_recommend/update', '', '', 0, '2021-12-23 16:27:23', NULL);
INSERT INTO `permissions` VALUES (63, 5, 61, 'brand_recommend_del', 'auth_admin', '刪除', 0, 1, 'admin/brand_recommend/del', '', '', 0, '2021-12-23 16:28:04', NULL);
INSERT INTO `permissions` VALUES (64, 2, 15, 'welcome_home', 'auth_admin', '歡迎頁面設置', 1, 0, '', '', 'lni lni-world', 2, '2021-12-23 16:30:03', '2021-12-24 14:24:03');
INSERT INTO `permissions` VALUES (65, 3, 64, 'welcome_app_list', 'auth_admin', 'app歡迎頁', 1, 1, 'admin/welcome/app_list', '', 'lni lni-list', 0, '2021-12-23 16:31:35', NULL);
INSERT INTO `permissions` VALUES (66, 4, 65, 'welcome_app_edit', 'auth_admin', '編輯', 0, 1, 'admin/welcome/app_edit', '', '', 0, '2021-12-23 16:32:32', NULL);
INSERT INTO `permissions` VALUES (67, 4, 65, 'welcome_app_del', 'auth_admin', '刪除', 0, 1, 'admin/welcome/app_del', '', '', 0, '2021-12-23 16:33:04', NULL);
INSERT INTO `permissions` VALUES (68, 3, 64, 'welcome_ad_list', 'auth_admin', '廣告頁', 1, 1, 'admin/welcome/ad_list', '', 'lni lni-list', 0, '2021-12-23 16:34:29', NULL);
INSERT INTO `permissions` VALUES (69, 4, 68, 'welcome_ad_edit', 'auth_admin', '編輯', 0, 1, 'admin/welcome/ad_edit', '', '', 0, '2021-12-23 16:35:08', NULL);
INSERT INTO `permissions` VALUES (70, 4, 68, 'welcome_ad_del', 'auth_admin', '刪除', 0, 1, 'admin/welcome/ad_del', '', '', 0, '2021-12-23 16:36:04', NULL);
INSERT INTO `permissions` VALUES (71, 2, 15, 'banner_list', 'auth_admin', 'Banner上稿', 1, 0, '', '', 'lni lni-image', 3, '2021-12-23 16:37:54', '2021-12-23 17:54:53');
INSERT INTO `permissions` VALUES (72, 3, 71, 'banner_team_buy_list', 'auth_admin', '團購Banner', 1, 1, 'admin/banner/team_buy_list', '', 'lni lni-list', 0, '2021-12-23 16:41:07', NULL);
INSERT INTO `permissions` VALUES (73, 4, 72, 'banner_team_buy_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/team_buy_edit', '', '', 0, '2021-12-23 16:41:53', NULL);
INSERT INTO `permissions` VALUES (74, 4, 72, 'banner_team_buy_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/team_buy_del', '', '', 0, '2021-12-23 16:43:32', NULL);
INSERT INTO `permissions` VALUES (75, 3, 71, 'banner_dividend_list', 'auth_admin', '紅利專區', 1, 1, 'admin/banner/dividend_list', '', 'lni lni-list', 0, '2021-12-23 16:44:40', NULL);
INSERT INTO `permissions` VALUES (76, 4, 75, 'banner_dividend_edit', 'auth_admin', '編輯', 0, 1, 'admin/banner/dividend_edit', '', '', 0, '2021-12-23 16:46:02', NULL);
INSERT INTO `permissions` VALUES (77, 4, 75, 'banner_dividend_del', 'auth_admin', '刪除', 0, 1, 'admin/banner/dividend_del', '', '', 0, '2021-12-23 16:47:51', NULL);
INSERT INTO `permissions` VALUES (78, 2, 15, 'wesite_home', 'auth_admin', '網站設定', 1, 0, '', '', 'lni lni-website', 5, '2021-12-23 16:48:43', '2021-12-23 17:49:07');
INSERT INTO `permissions` VALUES (79, 3, 78, 'website_basis_index', 'auth_admin', '網站設定', 1, 1, '/admin/website/basis', '', 'lni lni-edge', 0, '2021-12-23 16:51:11', NULL);
INSERT INTO `permissions` VALUES (80, 4, 79, 'website_update', 'auth_admin', '編輯', 0, 1, 'admin/website/update', '', '', 0, '2021-12-23 16:52:26', NULL);
INSERT INTO `permissions` VALUES (81, 3, 78, 'website_login_index', 'auth_admin', '登入設定', 1, 1, 'admin/website/login', '', 'lni lni-enter', 0, '2021-12-23 16:53:26', NULL);
INSERT INTO `permissions` VALUES (82, 3, 78, 'website_sms_index', 'auth_admin', '簡訊設置', 1, 1, 'admin/website/sms', '', 'lni lni-whatsapp', 0, '2021-12-23 16:54:21', NULL);
INSERT INTO `permissions` VALUES (83, 3, 78, 'website_email_index', 'auth_admin', '發信設置', 1, 1, 'admin/website/email', '', 'bx bx-envelope', 0, '2021-12-23 16:54:56', NULL);
INSERT INTO `permissions` VALUES (84, 3, 78, 'wesite_member_index', 'auth_admin', '會員服務條款', 1, 1, 'admin/website/member', '', 'lni lni-library', 0, '2021-12-23 16:55:50', NULL);
INSERT INTO `permissions` VALUES (85, 3, 78, 'website_privacy_index', 'auth_admin', '隱私權政策', 1, 1, 'admin/website/privacy', '', 'lni lni-library', 0, '2021-12-23 16:58:31', NULL);
INSERT INTO `permissions` VALUES (86, 2, 15, 'search_list', 'auth_admin', '搜尋管理', 1, 0, '', '', 'lni lni-keyword-research', 6, '2021-12-23 17:11:42', '2021-12-23 17:55:39');
INSERT INTO `permissions` VALUES (87, 3, 86, 'keyword_history_list', 'auth_admin', '搜尋歷史', 1, 1, 'admin/keyword/history', '', 'lni lni-list', 0, '2021-12-23 17:13:45', NULL);
INSERT INTO `permissions` VALUES (88, 3, 86, 'keyword_hint_list', 'auth_admin', '搜尋提示詞', 1, 1, 'admin/keyword/hint', '', 'lni lni-list', 0, '2021-12-23 17:14:55', NULL);
INSERT INTO `permissions` VALUES (89, 4, 88, 'keyword_history_edit', 'auth_admin', '編輯', 0, 1, 'admin/keyword/hint_edit', '', '', 0, '2021-12-23 17:16:29', NULL);
INSERT INTO `permissions` VALUES (90, 4, 88, 'keyword_hint_del', 'auth_admin', '刪除', 0, 1, 'admin/keyword/hint_del', '', '', 0, '2021-12-23 17:17:34', NULL);
INSERT INTO `permissions` VALUES (91, 2, 15, 'footer_index', 'auth_admin', 'Footer管理', 1, 1, 'admin/menu_footer', '', 'lni lni-pointer-down', 7, '2021-12-23 17:24:37', '2021-12-23 17:36:10');
INSERT INTO `permissions` VALUES (92, 3, 91, 'menu_footer_update', 'auth_admin', '編輯', 0, 1, 'admin/menu_footer/update', '', '', 0, '2021-12-23 17:26:01', NULL);
INSERT INTO `permissions` VALUES (93, 2, 15, 'pay_way_index', 'auth_admin', '金流設置', 1, 1, 'admin/pay_way', '', 'lni lni-amazon-pay', 9, '2021-12-23 17:30:14', '2021-12-23 17:38:49');
INSERT INTO `permissions` VALUES (94, 2, 15, 'invoice_list', 'auth_admin', '發票捐贈', 1, 1, 'admin/invoice', '', 'bx bx-file', 10, '2021-12-23 17:31:51', '2021-12-23 17:40:47');
INSERT INTO `permissions` VALUES (95, 3, 86, 'keyword_hot_index', 'auth_admin', '熱門搜尋詞', 1, 1, 'admin/keyword/hot', '', 'lni lni-list', 0, '2021-12-24 11:35:51', NULL);
INSERT INTO `permissions` VALUES (96, 4, 95, 'keyword_hot_update', 'auth_admin', '編輯', 0, 1, 'admin/keyword/hot_update', '', '', 0, '2021-12-24 11:36:46', NULL);

SET FOREIGN_KEY_CHECKS = 1;
