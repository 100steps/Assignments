//
//  AddViewController.h
//  CoreDataDemo2
//
//  Created by 陈泽康 on 2016/10/30.
//  Copyright © 2016年 zekang. All rights reserved.
//

#import <UIKit/UIKit.h>
//写一下代理协议
//导入视图控制器和模型
@class AddViewController,ContactModel;
@protocol AddViewControllerDelegate <NSObject>

@optional
- (void)addContact:(AddViewController *)addVc didAddContact:(ContactModel *)contact;

@end


@interface AddViewController : UIViewController
@property (nonatomic,assign) id<AddViewControllerDelegate>delegate;
@end
