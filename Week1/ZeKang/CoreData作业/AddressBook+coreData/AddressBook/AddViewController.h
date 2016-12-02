
#import <UIKit/UIKit.h>
//在声明文件中写协议
@class AddViewController,ContactModel;
//导入视图控制器和模型
@protocol AddViewControllerDelegate <NSObject>
@optional
- (void)addContact:(AddViewController *)addVc didAddContact:(ContactModel *)contact;
//声明协议和方法,把模型数据作为参数传递
@end

@interface AddViewController : UIViewController

@property (nonatomic,assign) id<AddViewControllerDelegate> delegate;
//声明代理属性
@end
