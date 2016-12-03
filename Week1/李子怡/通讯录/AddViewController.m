//
//  AddViewController.m
//  通讯录
//
//  Created by apple on 2016/10/6.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "AddViewController.h"
#import <CoreData/CoreData.h>
#import "People+CoreDataProperties.h"
#import "pinyin.h"
@interface AddViewController ()<UIImagePickerControllerDelegate,UINavigationControllerDelegate>






- (IBAction)backaction:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *nameField;
@property (weak, nonatomic) IBOutlet UITextField *phoneField;
@property (weak, nonatomic) IBOutlet UITextField *qqField;
@property (weak, nonatomic) IBOutlet UIButton *addBtn;
- (IBAction)AddAction;
@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property (weak, nonatomic) UIImage *image;
- (IBAction)chooseImage:(id)sender;
//声明coreDate的上下文
@property (strong, nonatomic) NSManagedObjectContext * managedObjectContext;


@end

@implementation AddViewController


#pragma mark - 获取本应用的上下文对象
-(NSManagedObjectContext *)applicationManagedObjectContext{
    UIApplication * application = [UIApplication sharedApplication];
    id delegate = application.delegate;
    //返回应用的上下文对象
    return [delegate managedObjectContext];
}



- (void)viewDidLoad {
   //添加观察者
    [super viewDidLoad];
    //获取应用的上下文
    self. managedObjectContext = [self applicationManagedObjectContext];
    

    
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. nameField];
    
   [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. phoneField];
    
   [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(textChange) name:(UITextFieldTextDidChangeNotification) object:self. qqField];
    

    
}

-(void) textChange{
    self. addBtn. enabled = (self. nameField. text. length && (self. phoneField. text. length || self. qqField. text. length));
}



-(void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    //让姓名文本成为第一响应者（叫出键盘）
    [self. nameField becomeFirstResponder];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/




- (IBAction)backaction:(id)sender {
    [self. navigationController popViewControllerAnimated:NO];
}

- (IBAction)AddAction {

    //获取people的实体对象
    People * people = [NSEntityDescription insertNewObjectForEntityForName:NSStringFromClass([People class]) inManagedObjectContext:self.managedObjectContext];
    
    //为对象设置属性
    people. name = self. nameField.text;
    people. phone = self.phoneField.text;
    people. qq = self. qqField.text;
    people. firstN = [NSString stringWithFormat:@"%c", pinyinFirstLetter([people. name characterAtIndex:0]) - 32];
  
    people. image = UIImagePNGRepresentation(_image);
    
     //上下文对象保存
    NSError * error;
    if (![self.managedObjectContext save:&error]){
        NSLog(@"%@",[error localizedDescription]);
    }
    
    [self. navigationController popViewControllerAnimated:YES];
    
    
    
    //代理传值
  /*  if ([self. delegate respondsToSelector: @selector(addContact:didAddContact:)]){
        JKContactModel *contactModel = [[JKContactModel alloc] init];
        
        contactModel. name = self. nameField. text;
        contactModel. phone = self. phoneField. text;
        contactModel. qq = self. qqField. text;
        
        [self.delegate addContact:self didAddContact:contactModel];
    }*/
    
    
    
}

- (IBAction)chooseImage:(id)sender {
    UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"选择" message:nil preferredStyle:UIAlertControllerStyleActionSheet];
    
    [alert addAction:[UIAlertAction actionWithTitle:@"取消" style: UIAlertActionStyleCancel handler:nil]];
    
    //借鉴ZHGPhotoDemo.xcodeproj 与 simpleTable.xcodeproj 与https://my.oschina.net/joanfen/blog/134677
    
    UIAlertAction *cameralButton = [UIAlertAction actionWithTitle:@"相机" style:UIAlertActionStyleDefault handler:^(UIAlertAction * _Nonnull action) {
        
        if ([UIImagePickerController isSourceTypeAvailable:UIImagePickerControllerSourceTypeCamera]) {
            //图片资源来自相册
            //UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypeCamera;
            UIImagePickerController *imageCameral = [[UIImagePickerController alloc] init];
            imageCameral.sourceType = UIImagePickerControllerSourceTypeCamera;
            imageCameral.cameraDevice = UIImagePickerControllerCameraDeviceRear;
            //设置选取代理
            imageCameral.delegate = self;
           //使用模态窗口显示相册
            [self presentViewController:imageCameral animated:YES completion:nil];
            
        }else {
            
            UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"提示" message:@"该设备不支持照相功能" preferredStyle:UIAlertControllerStyleAlert];
            
            UIAlertAction *cancel = [UIAlertAction actionWithTitle:@"确定" style:UIAlertActionStyleCancel handler:nil];
            
            [alert addAction:cancel];
            
            [self presentViewController:alert animated:YES completion:nil];
        }
        
    }];
    
    
    
    
    UIAlertAction *photoButton =[UIAlertAction actionWithTitle:@"从相册中选取" style:UIAlertActionStyleDefault handler:^(UIAlertAction * _Nonnull action) {
         //图片资源来自相册
      //  UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
        UIImagePickerController *imagePhoto = [[UIImagePickerController alloc] init];
        imagePhoto. sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
           //设置选取代理
        imagePhoto. delegate = self;

        //使用模态窗口显示相册
        [self presentViewController:imagePhoto animated:YES completion:nil];
        
    }];
    
    [alert addAction:cameralButton];
    [alert addAction:photoButton];
    
    
    [self presentViewController:alert animated:YES completion:nil];

   
}

-(void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    //NSLog(@"%@",info);
    //info：这个字典中放着图片的具体信息,通过这个字典的键可以获取图片
    
    //取出图片
    self. image = [info objectForKey:UIImagePickerControllerOriginalImage];//显示图片在图像视图中
    [self. imageView setImage: self. image];
    
    //关闭模态窗口
    [picker dismissViewControllerAnimated:YES completion:nil];
}
@end
