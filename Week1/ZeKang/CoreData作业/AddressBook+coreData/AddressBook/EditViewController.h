

#import <UIKit/UIKit.h>
@class ContactModel,EditViewController;
//导入模型和编辑视图控制器
@protocol EditViewControllerDelegate <NSObject>

@optional
-(void)enditViewController:(EditViewController *)editVc didSaveContact:(ContactModel *)model;
//声明编辑视图代理的协议和代理方法

@end
@interface EditViewController : UIViewController

@property (nonatomic,assign) id<EditViewControllerDelegate>delegate;
//声明代理属性
@property (nonatomic,strong) ContactModel *contactModel;
//声明模型属性
@end
